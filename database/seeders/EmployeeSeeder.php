<?php

namespace Database\Seeders;

use App\Models\Employee;
use App\Models\Employer;
use App\Models\EmploymentRecord;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class EmployeeSeeder extends Seeder
{
    // ── Rwandan names pool ─────────────────────────────────────────────────────

    private array $firstNamesMale = [
        'Jean', 'Eric', 'Patrick', 'Claude', 'Alexis',
        'Thierry', 'Kevin', 'Olivier', 'Fabrice', 'Samuel',
        'Didier', 'Innocent', 'Emmanuel', 'Desire', 'Francois',
        'Gerard', 'Joseph', 'Michel', 'Pierre', 'Sylvain',
    ];

    private array $firstNamesFemale = [
        'Marie', 'Ange', 'Clarisse', 'Solange', 'Diane',
        'Annette', 'Chantal', 'Beatrice', 'Nadine', 'Stephanie',
        'Judith', 'Celestine', 'Odette', 'Josephine', 'Valerie',
        'Esperance', 'Immaculee', 'Vestine', 'Alphonsine', 'Rosine',
    ];

    private array $lastNames = [
        'Uwimana', 'Ndayishimiye', 'Habimana', 'Nzeyimana', 'Hakizimana',
        'Nizeyimana', 'Tuyishime', 'Mugisha', 'Nshimiyimana', 'Kayitesi',
        'Uwase', 'Ingabire', 'Niyonzima', 'Maniraguha', 'Bizimana',
        'Nsanzimana', 'Hategekimana', 'Kamanzi', 'Rurangwa', 'Gahigi',
    ];

    private array $districts = [
        'Gasabo', 'Kicukiro', 'Nyarugenge',
        'Bugesera', 'Rwamagana', 'Kayonza',
        'Muhanga', 'Kamonyi', 'Ruhango',
    ];

    private array $qualifications = [
        'Bachelor of Business Administration',
        'Bachelor of Science in Computer Science',
        'Diploma in Accounting',
        'Bachelor of Arts in Communication',
        'Certificate in Hospitality Management',
        'Bachelor of Science in Nursing',
        'Diploma in Tourism and Travel',
        'Bachelor of Education',
        'Certificate in Office Management',
        'Bachelor of Commerce',
    ];

    private array $skillSets = [
        ['Customer Service', 'Communication', 'MS Office'],
        ['Accounting', 'QuickBooks', 'Data Entry'],
        ['PHP', 'Laravel', 'MySQL', 'JavaScript'],
        ['Tourism', 'Tour Guide', 'French', 'English'],
        ['Reception', 'Front Desk', 'Reservations'],
        ['Data Analysis', 'Excel', 'PowerPoint'],
        ['Logistics', 'Supply Chain', 'Inventory Management'],
        ['HR Management', 'Recruitment', 'Payroll'],
        ['Marketing', 'Social Media', 'Content Writing'],
        ['Project Management', 'Leadership', 'Reporting'],
    ];

    // ── Main ───────────────────────────────────────────────────────────────────

    public function run(): void
    {
        $employers = Employer::all();

        if ($employers->isEmpty()) {
            $this->command->warn('No employers found. Run EmployerSeeder first.');
            return;
        }

        $counter = 1;

        foreach ($employers as $employer) {
            $this->command->info("Seeding 10 employees for: {$employer->name}");

            for ($i = 1; $i <= 10; $i++) {
                $gender    = $counter % 2 === 0 ? 'male' : 'female';
                $firstName = $gender === 'male'
                    ? $this->firstNamesMale[($counter - 1) % count($this->firstNamesMale)]
                    : $this->firstNamesFemale[($counter - 1) % count($this->firstNamesFemale)];
                $lastName  = $this->lastNames[($counter - 1) % count($this->lastNames)];
                $email     = strtolower("{$firstName}.{$lastName}{$counter}@nlrehv.rw");
                $nationalId = str_pad($counter, 16, '1', STR_PAD_LEFT);
                $dob       = now()->subYears(rand(22, 45))->subDays(rand(0, 365))->format('Y-m-d');

                // Create login user
                $user = User::firstOrCreate(
                    ['email' => $email],
                    [
                        'name'      => "{$firstName} {$lastName}",
                        'password'  => Hash::make('password'),
                        'role'      => 'employee',
                        'is_active' => true,
                    ]
                );

                // Create employee record
                $employee = Employee::firstOrCreate(
                    ['national_id' => $nationalId],
                    [
                        'user_id'               => $user->id,
                        'first_name'            => $firstName,
                        'last_name'             => $lastName,
                        'middle_name'           => null,
                        'date_of_birth'         => $dob,
                        'gender'                => $gender,
                        'phone'                 => '+2507' . rand(80, 89) . str_pad(rand(0, 999999), 6, '0', STR_PAD_LEFT),
                        'email'                 => $email,
                        'district'              => $this->districts[$counter % count($this->districts)],
                        'province'              => 'Kigali City',
                        'current_employer_id'   => $employer->id,
                        'status'                => 'active',
                        'highest_qualification' => $this->qualifications[$counter % count($this->qualifications)],
                        'skills'                => $this->skillSets[$counter % count($this->skillSets)],
                    ]
                );

                // Create an active employment record (no end_date = currently employed)
                EmploymentRecord::firstOrCreate(
                    [
                        'employee_id' => $employee->id,
                        'employer_id' => $employer->id,
                        'end_date'    => null,
                    ],
                    [
                        'position'    => $this->position($employer->sector),
                        'start_date'  => now()->subMonths(rand(3, 36))->format('Y-m-d'),
                        'end_date'    => null,
                        'status'      => 'active',
                        'recorded_by' => $employer->user_id,
                    ]
                );

                $counter++;
            }
        }

        $this->command->info('Done — ' . ($counter - 1) . ' employees seeded.');
    }

    // ── Position by sector ─────────────────────────────────────────────────────

    private function position(string $sector): string
    {
        return match ($sector) {
            'public_administration' => collect([
                'Administrative Officer', 'Records Manager', 'Community Development Officer',
                'Finance Officer', 'Secretary', 'IT Officer',
            ])->random(),

            'bpo_call_center' => collect([
                'Customer Service Agent', 'Team Leader', 'Quality Assurance Analyst',
                'Data Entry Operator', 'Technical Support Agent', 'Trainer',
            ])->random(),

            'hospitality_tourism' => collect([
                'Front Desk Officer', 'Tour Guide', 'Reservations Agent',
                'Housekeeping Supervisor', 'Food & Beverage Attendant', 'Concierge',
            ])->random(),

            default => 'Staff',
        };
    }
}