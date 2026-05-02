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
        'position',
        'department',
        'salary',
        'start_date',
        'end_date',
        'exit_reason',
        'exit_details',
        'conduct_rating',
        'conduct_remarks',
        'eligible_for_rehire',
        'status',
        'recorded_by',
    ];

    protected $casts = [
        'start_date'          => 'date',
        'end_date'            => 'date',
        'eligible_for_rehire' => 'boolean',
        'salary'              => 'decimal:2',
    ];

    // ── Accessors ──────────────────────────────────────────────────────────────
    public function getIsActiveAttribute(): bool
    {
        return is_null($this->end_date);
    }

    public function getDurationAttribute(): string
{
    $end = $this->end_date ?? now();
    $diff = $this->start_date->diff($end);
    $parts = [];
    if ($diff->y) $parts[] = "{$diff->y}y";
    if ($diff->m) $parts[] = "{$diff->m}m";
    if (!$diff->y && !$diff->m) $parts[] = "{$diff->d}d";
    return implode(' ', $parts) ?: '< 1 day';
}

    public function getConductBadgeAttribute(): string
    {
        return match ($this->conduct_rating) {
            'excellent'  => 'bg-emerald-100 text-emerald-800',
            'good'       => 'bg-blue-100 text-blue-800',
            'satisfactory' => 'bg-amber-100 text-amber-800',
            'poor'       => 'bg-orange-100 text-orange-800',
            'very_poor'  => 'bg-red-100 text-red-800',
            default      => 'bg-gray-100 text-gray-800',
        };
    }

    public function getExitReasonLabelAttribute(): string
    {
        return match ($this->exit_reason) {
            'resigned'         => 'Resigned',
            'terminated'       => 'Terminated',
            'contract_ended'   => 'Contract Ended',
            'transferred'      => 'Transferred',
            'retired'          => 'Retired',
            'deceased'         => 'Deceased',
            'redundancy'       => 'Redundancy',
            'mutual_agreement' => 'Mutual Agreement',
            default            => 'Other',
        };
    }

    // ── Relationships ──────────────────────────────────────────────────────────
    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }

    public function employer()
    {
        return $this->belongsTo(Employer::class);
    }

    public function recordedBy()
    {
        return $this->belongsTo(User::class, 'recorded_by');
    }

    public function claims()
    {
        return $this->hasMany(Claim::class);
    }
}
