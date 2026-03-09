<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class EmploymentRecord extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'employee_id',
        'employer_id',
        'job_title',
        'department',
        'employment_type',
        'salary_start',
        'salary_end',
        'salary_currency',
        'job_description',
        'start_date',
        'end_date',
        'is_current',
        'exit_reason',
        'exit_details',
        'exit_reference_number',
        'record_source',
        'employer_verified',
        'employer_verified_at',
        'employee_confirmed',
        'employee_confirmed_at',
        'under_dispute',
        'employee_dispute_note',
        'dispute_status',
    ];

    protected $casts = [
        'start_date'            => 'date',
        'end_date'              => 'date',
        'is_current'            => 'boolean',
        'employer_verified'     => 'boolean',
        'employer_verified_at'  => 'datetime',
        'employee_confirmed'    => 'boolean',
        'employee_confirmed_at' => 'datetime',
        'under_dispute'         => 'boolean',
    ];

    // ── Relationships ────────────────────────────────────────

    public function employee(): BelongsTo
    {
        return $this->belongsTo(Employee::class);
    }

    public function employer(): BelongsTo
    {
        return $this->belongsTo(Employer::class);
    }

    public function feedback(): HasOne
    {
        return $this->hasOne(ProfessionalFeedback::class);
    }

    // ── Accessors ────────────────────────────────────────────

    public function getDurationAttribute(): string
    {
        $end    = $this->end_date ?? now();
        $months = $this->start_date->diffInMonths($end);
        $years  = intdiv($months, 12);
        $rem    = $months % 12;

        $parts = [];
        if ($years) $parts[] = "{$years} yr" . ($years > 1 ? 's' : '');
        if ($rem)   $parts[] = "{$rem} mo";

        return implode(' ', $parts) ?: 'Less than a month';
    }

    public function getExitReasonLabelAttribute(): string
    {
        return match($this->exit_reason) {
            'resignation'            => 'Resignation',
            'contract_expiry'        => 'Contract Expiry',
            'mutual_agreement'       => 'Mutual Agreement',
            'redundancy'             => 'Redundancy',
            'dismissal_misconduct'   => 'Dismissal — Misconduct',
            'dismissal_performance'  => 'Dismissal — Performance',
            'medical_grounds'        => 'Medical Grounds',
            'retirement'             => 'Retirement',
            'death'                  => 'Death',
            'other'                  => 'Other',
            default                  => 'N/A',
        };
    }

    // ── Scopes ───────────────────────────────────────────────

    public function scopeCurrent($query)
    {
        return $query->where('is_current', true);
    }

    public function scopeVerified($query)
    {
        return $query->where('employer_verified', true);
    }

    public function scopeUnderDispute($query)
    {
        return $query->where('under_dispute', true);
    }
}