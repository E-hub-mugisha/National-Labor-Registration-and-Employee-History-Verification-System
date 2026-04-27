<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Claim extends Model
{
    use HasFactory;

    protected $fillable = [
        'employee_id',
        'employment_record_id',
        'claim_type',
        'description',
        'evidence_file',
        'status',
        'admin_note',
        'employer_response',
        'reviewed_by',
        'reviewed_at',
    ];

    protected $casts = [
        'reviewed_at' => 'datetime',
    ];

    public function getClaimTypeLabelAttribute(): string
    {
        return match ($this->claim_type) {
            'wrong_exit_reason'    => 'Incorrect Exit Reason',
            'wrong_conduct_rating' => 'Incorrect Conduct Rating',
            'wrong_dates'          => 'Incorrect Employment Dates',
            'wrong_position'       => 'Incorrect Position/Title',
            'wrong_remarks'        => 'Incorrect Conduct Remarks',
            default                => 'Other Dispute',
        };
    }

    public function getStatusBadgeAttribute(): string
    {
        return match ($this->status) {
            'pending'      => 'bg-amber-100 text-amber-800',
            'under_review' => 'bg-blue-100 text-blue-800',
            'resolved'     => 'bg-emerald-100 text-emerald-800',
            'rejected'     => 'bg-red-100 text-red-800',
            default        => 'bg-gray-100 text-gray-800',
        };
    }

    // ── Relationships ──────────────────────────────────────────────────────────
    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }
    public function employmentRecord()
    {
        return $this->belongsTo(EmploymentRecord::class);
    }
    public function reviewedBy()
    {
        return $this->belongsTo(User::class, 'reviewed_by');
    }
}
