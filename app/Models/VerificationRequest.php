<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class VerificationRequest extends Model
{
    use HasFactory;

    protected $fillable = [
        'employer_id',
        'requested_by',
        'national_id_queried',
        'employee_id',
        'purpose',
        'purpose_details',
        'position_applied_for',
        'employee_found',
        'data_returned',
        'status',
        'employee_consent_obtained',
        'consent_reference',
        'ip_address',
        'searched_at',
    ];

    protected $casts = [
        'employee_found'            => 'boolean',
        'data_returned'             => 'array',
        'employee_consent_obtained' => 'boolean',
        'searched_at'               => 'datetime',
    ];

    // ── Relationships ────────────────────────────────────────

    public function employer(): BelongsTo
    {
        return $this->belongsTo(Employer::class);
    }

    public function requestedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'requested_by');
    }

    public function employee(): BelongsTo
    {
        return $this->belongsTo(Employee::class);
    }

    // ── Accessors ────────────────────────────────────────────

    public function getPurposeLabelAttribute(): string
    {
        return match($this->purpose) {
            'pre_employment_check'   => 'Pre-Employment Check',
            'background_verification'=> 'Background Verification',
            'contract_renewal'       => 'Contract Renewal',
            'security_clearance'     => 'Security Clearance',
            'other'                  => 'Other',
            default                  => 'Unknown',
        };
    }

    public function getMaskedNationalIdAttribute(): string
    {
        return substr($this->national_id_queried, 0, 4)
            . str_repeat('*', strlen($this->national_id_queried) - 7)
            . substr($this->national_id_queried, -3);
    }

    // ── Scopes ───────────────────────────────────────────────

    public function scopeSuccessful($query)
    {
        return $query->where('employee_found', true);
    }

    public function scopeToday($query)
    {
        return $query->whereDate('searched_at', today());
    }

    public function scopeThisMonth($query)
    {
        return $query->whereMonth('searched_at', now()->month)
                     ->whereYear('searched_at', now()->year);
    }
}