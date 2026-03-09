<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class EmployeeQualification extends Model
{
    use HasFactory;

    protected $fillable = [
        'employee_id',
        'type',
        'institution_name',
        'qualification_title',
        'field_of_study',
        'start_date',
        'end_date',
        'is_current',
        'certificate_number',
        'certificate_document',
        'is_verified',
    ];

    protected $casts = [
        'start_date'  => 'date',
        'end_date'    => 'date',
        'is_current'  => 'boolean',
        'is_verified' => 'boolean',
    ];

    // ── Relationships ────────────────────────────────────────

    public function employee(): BelongsTo
    {
        return $this->belongsTo(Employee::class);
    }

    // ── Accessors ────────────────────────────────────────────

    public function getTypeLabelAttribute(): string
    {
        return match($this->type) {
            'academic'       => 'Academic',
            'professional'   => 'Professional',
            'vocational'     => 'Vocational',
            'certification'  => 'Certification',
            'other'          => 'Other',
            default          => 'Unknown',
        };
    }

    public function getDurationAttribute(): string
    {
        if ($this->is_current) {
            return $this->start_date->format('Y') . ' — Present';
        }

        if ($this->start_date && $this->end_date) {
            return $this->start_date->format('Y') . ' — ' . $this->end_date->format('Y');
        }

        return $this->end_date?->format('Y') ?? 'N/A';
    }

    // ── Scopes ───────────────────────────────────────────────

    public function scopeVerified($query)
    {
        return $query->where('is_verified', true);
    }

    public function scopeOfType($query, string $type)
    {
        return $query->where('type', $type);
    }
}