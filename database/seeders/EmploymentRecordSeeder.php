<?php

namespace Database\Seeders;

use App\Models\Employee;
use App\Models\Employer;
use App\Models\EmploymentRecord;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;

class EmploymentRecordSeeder extends Seeder
{
    // ── Positions per sector ───────────────────────────────────────────────────

    private array $positions = [
        'public_administration' => [
            'Administrative Officer', 'Records Manager', 'Community Development Officer',
            'Finance Officer', 'Secretary', 'IT Officer', 'Legal Counsel', 'Procurement Officer',
        ],
        'bpo_call_center' => [
            'Customer Service Agent', 'Team Leader', 'Quality Assurance Analyst',
            'Data Entry Operator', 'Technical Support Agent', 'Trainer', 'Operations Supervisor',
        ],
        'hospitality_tourism' => [
            'Front Desk Officer', 'Tour Guide', 'Reservations Agent',
            'Housekeeping Supervisor', 'Food & Beverage Attendant', 'Concierge',
            'Events Coordinator', 'Sales Executive',
        ],
        'default' => [
            'Staff', 'Officer', 'Coordinator', 'Analyst', 'Supervisor', 'Manager',
        ],
    ];

    private array $departments = [
        'public_administration' => [
            'Administration', 'Finance', 'IT', 'Legal', 'Procurement', 'Community Services',
        ],
        'bpo_call_center' => [
            'Operations', 'Quality Assurance', 'Training', 'Technical Support', 'HR',
        ],
        'hospitality_tourism' => [
            'Front Office', 'Housekeeping', 'Food & Beverage', 'Sales & Marketing',
            'Tours & Activities', 'Finance',
        ],
        'default' => [
            'Operations', 'Finance', 'HR', 'Administration',
        ],
    ];

    private array $exitReasons = [
        'resigned', 'terminated', 'contract_ended', 'transferred',
        'retired', 'redundancy', 'mutual_agreement',
    ];

    private array $conductRatings = [
        'excellent', 'excellent', 'good', 'good', 'good',   // weighted toward good
        'satisfactory', 'satisfactory', 'poor', 'very_poor',
    ];

    private array $conductRemarks = [
        'excellent'    => 'Exceptional performance and dedication throughout tenure.',
        'good'         => 'Consistently met expectations and contributed positively.',
        'satisfactory' => 'Performance was adequate; met basic job requirements.',
        'poor'         => 'Frequent performance issues noted during employment.',
        'very_poor'    => 'Significant conduct and performance problems throughout.',
    ];

    private array $exitDetails = [
        'resigned'         => 'Employee submitted formal resignation letter.',
        'terminated'       => 'Employment terminated due to performance issues.',
        'contract_ended'   => 'Fixed-term contract reached its natural end date.',
        'transferred'      => 'Employee transferred to another department or employer.',
        'retired'          => 'Employee reached retirement age and formally retired.',
        'redundancy'       => 'Position made redundant due to organisational restructuring.',
        'mutual_agreement' => 'Both parties agreed to end the employment relationship.',
    ];

    // ── Run ────────────────────────────────────────────────────────────────────

    public function run(): void
    {
        $employees = Employee::with('currentEmployer')->get();

        if ($employees->isEmpty()) {
            $this->command->warn('No employees found. Run EmployeeSeeder first.');
            return;
        }

        $employers     = Employer::all()->keyBy('id');
        $allEmployerIds = $employers->keys()->toArray();
        $created       = 0;

        foreach ($employees as $index => $employee) {
            $currentEmployerId = $employee->current_employer_id;
            $currentEmployer   = $employers->get($currentEmployerId);
            $sector            = $currentEmployer?->sector ?? 'default';

            // ── 1. Past records (1–2 previous employers) ───────────────────────
            $pastCount = $index % 3 === 0 ? 2 : 1;   // every 3rd employee gets 2 past jobs
            $cursor    = now()->subYears(rand(4, 8));  // start far enough back

            for ($p = 0; $p < $pastCount; $p++) {
                // Pick a past employer different from the current one
                $pastEmployerId = collect($allEmployerIds)
                    ->reject(fn ($id) => $id === $currentEmployerId)
                    ->values()
                    ->get($p % (count($allEmployerIds) - 1));

                if (! $pastEmployerId) continue;

                $pastEmployer  = $employers->get($pastEmployerId);
                $pastSector    = $pastEmployer?->sector ?? 'default';
                $startDate     = $cursor->copy();
                $endDate       = $startDate->copy()->addMonths(rand(8, 24));
                $exitReason    = $this->exitReasons[array_rand($this->exitReasons)];
                $conductRating = $this->conductRatings[array_rand($this->conductRatings)];
                $salary        = $this->salaryFor($pastSector);

                EmploymentRecord::firstOrCreate(
                    [
                        'employee_id' => $employee->id,
                        'employer_id' => $pastEmployerId,
                        'start_date'  => $startDate->format('Y-m-d'),
                    ],
                    [
                        'position'           => $this->pickPosition($pastSector),
                        'department'         => $this->pickDepartment($pastSector),
                        'salary'             => $salary,
                        'start_date'         => $startDate->format('Y-m-d'),
                        'end_date'           => $endDate->format('Y-m-d'),
                        'exit_reason'        => $exitReason,
                        'exit_details'       => $this->exitDetails[$exitReason],
                        'conduct_rating'     => $conductRating,
                        'conduct_remarks'    => $this->conductRemarks[$conductRating],
                        'eligible_for_rehire'=> ! in_array($conductRating, ['poor', 'very_poor']),
                        'status'             => 'inactive',
                        'recorded_by'        => $pastEmployer?->user_id,
                    ]
                );

                $cursor = $endDate->copy()->addDays(rand(7, 60)); // gap between jobs
                $created++;
            }

            // ── 2. Current / active record ─────────────────────────────────────
            $activeStart   = $cursor->copy();
            $conductRating = $this->conductRatings[array_rand($this->conductRatings)];
            $salary        = $this->salaryFor($sector);

            EmploymentRecord::firstOrCreate(
                [
                    'employee_id' => $employee->id,
                    'employer_id' => $currentEmployerId,
                    'end_date'    => null,
                ],
                [
                    'position'           => $this->pickPosition($sector),
                    'department'         => $this->pickDepartment($sector),
                    'salary'             => $salary,
                    'start_date'         => $activeStart->format('Y-m-d'),
                    'end_date'           => null,
                    'exit_reason'        => null,
                    'exit_details'       => null,
                    'conduct_rating'     => $conductRating,
                    'conduct_remarks'    => $this->conductRemarks[$conductRating],
                    'eligible_for_rehire'=> true,
                    'status'             => 'active',
                    'recorded_by'        => $currentEmployer?->user_id,
                ]
            );

            $created++;
        }

        $this->command->info("Done — {$created} employment records seeded.");
    }

    // ── Helpers ────────────────────────────────────────────────────────────────

    private function pickPosition(string $sector): string
    {
        $pool = $this->positions[$sector] ?? $this->positions['default'];
        return $pool[array_rand($pool)];
    }

    private function pickDepartment(string $sector): string
    {
        $pool = $this->departments[$sector] ?? $this->departments['default'];
        return $pool[array_rand($pool)];
    }

    private function salaryFor(string $sector): float
    {
        return match ($sector) {
            'public_administration' => rand(150_000, 400_000) / 100,   // 1,500 – 4,000 RWF (×100 for frw)
            'bpo_call_center'       => rand(120_000, 350_000) / 100,
            'hospitality_tourism'   => rand(100_000, 300_000) / 100,
            default                 => rand(100_000, 500_000) / 100,
        };
    }
}