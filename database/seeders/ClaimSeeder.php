<?php

namespace Database\Seeders;

use App\Models\Claim;
use App\Models\Employee;
use App\Models\EmploymentRecord;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class ClaimSeeder extends Seeder
{
    private array $claimTypes = [
        'wrong_exit_reason',
        'wrong_conduct_rating',
        'wrong_dates',
        'wrong_position',
        'wrong_remarks',
    ];

    private array $descriptions = [
        'wrong_exit_reason' => [
            'I did not resign voluntarily. I was forced out due to workplace pressure and the exit reason recorded is inaccurate.',
            'The record shows I was terminated, but my contract simply ended as planned. Please correct the exit reason.',
            'I retired on agreed terms but my record incorrectly states redundancy. This needs to be corrected.',
        ],
        'wrong_conduct_rating' => [
            'My conduct rating of "poor" is unjust. I consistently received positive feedback from my supervisor during my tenure.',
            'I was rated "very poor" without any prior written warnings. I dispute this rating and request a review.',
            'My performance appraisals were always satisfactory or above, yet my final rating shows "poor".',
        ],
        'wrong_dates' => [
            'My start date is listed as incorrect. I joined the organisation three months earlier than what is recorded.',
            'The end date on my employment record does not match my official exit letter. Please verify and correct.',
            'Both my start and end dates are wrong. I have supporting documents to prove the correct dates.',
        ],
        'wrong_position' => [
            'I was employed as a Senior Officer, not as a general Staff member as shown in the record.',
            'My job title was updated during my employment but the record still reflects my initial position.',
            'The position listed does not match the role I was actually performing for the majority of my tenure.',
        ],
        'wrong_remarks' => [
            'The conduct remarks contain inaccurate statements about my behaviour that were never formally raised with me.',
            'I was never informed of the negative remarks recorded. These are misleading and I request their removal.',
            'The remarks do not reflect my actual performance. My line manager had confirmed no issues at the time of exit.',
        ],
    ];

    private array $adminNotes = [
        'pending'      => null,
        'under_review' => 'Claim forwarded to the relevant employer for verification. Awaiting response.',
        'resolved'     => 'Claim reviewed and confirmed. Record updated accordingly.',
        'rejected'     => 'Claim reviewed. Insufficient evidence to support the dispute. Record stands as is.',
    ];

    private array $employerResponses = [
        'under_review' => 'We are reviewing the claim internally and will respond within 5 business days.',
        'resolved'     => 'After internal review, we confirm the error and agree to the correction.',
        'rejected'     => 'We have reviewed this claim and stand by the accuracy of the original record.',
        'pending'      => null,
    ];

    public function run(): void
    {
        // Only employees who have at least one closed (past) employment record can file a claim
        $eligibleRecords = EmploymentRecord::whereNotNull('end_date')
            ->with('employee')
            ->get();

        if ($eligibleRecords->isEmpty()) {
            $this->command->warn('No closed employment records found. Run EmploymentRecordSeeder first.');
            return;
        }

        $reviewer = User::where('role', 'government')->first()
            ?? User::where('role', 'admin')->first();

        $statuses = ['pending', 'pending', 'under_review', 'resolved', 'rejected'];
        $created  = 0;

        foreach ($eligibleRecords as $index => $record) {
            // Not every record gets a claim — roughly 1 in 2
            if ($index % 2 !== 0) continue;

            $claimType   = $this->claimTypes[$index % count($this->claimTypes)];
            $status      = $statuses[$index % count($statuses)];
            $descriptions = $this->descriptions[$claimType];
            $description = $descriptions[$index % count($descriptions)];

            $reviewedBy = in_array($status, ['resolved', 'rejected']) ? $reviewer?->id : null;
            $reviewedAt = $reviewedBy ? now()->subDays(rand(1, 30)) : null;
            $referenceNumber = strtoupper(Str::random(10));

            Claim::firstOrCreate(
                [
                    'employee_id'          => $record->employee_id,
                    'employment_record_id' => $record->id,
                    'claim_type'           => $claimType,
                ],
                [
                    'description'       => $description,
                    'evidence_file'     => null,
                    'status'            => $status,
                    'admin_note'        => $this->adminNotes[$status],
                    'employer_response' => $this->employerResponses[$status],
                    'reviewed_by'       => $reviewedBy,
                    'reviewed_at'       => $reviewedAt,
                    'reference_number'  => $referenceNumber,
                ]
            );

            $created++;
        }

        $this->command->info("Done — {$created} claims seeded.");
    }
}