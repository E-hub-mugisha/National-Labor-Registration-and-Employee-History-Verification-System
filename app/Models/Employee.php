<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Employee extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'user_id',
        'national_id',
        'first_name',
        'last_name',
        'middle_name',
        'date_of_birth',
        'gender',
        'nationality',
        'province',
        'district',
        'sector',
        'phone_primary',
        'phone_secondary',
        'email',
        'address',
        'current_job_title',
        'employment_status',
        'professional_summary',
        'languages',
        'nida_verified',
        'nida_verified_at',
        'nida_verification_ref',
        'profile_complete',
        'is_searchable',
    ];

    protected $casts = [
        'date_of_birth'     => 'date',
        'nida_verified'     => 'boolean',
        'nida_verified_at'  => 'datetime',
        'profile_complete'  => 'boolean',
        'is_searchable'     => 'boolean',
        'languages'         => 'array',
    ];

    // ── Relationships ────────────────────────────────────────

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function skills(): HasMany
    {
        return $this->hasMany(EmployeeSkill::class);
    }

    public function qualifications(): HasMany
    {
        return $this->hasMany(EmployeeQualification::class)
                    ->orderByDesc('end_date');
    }

    public function employmentRecords(): HasMany
    {
        return $this->hasMany(EmploymentRecord::class)
                    ->orderByDesc('start_date');
    }

    public function currentEmployment(): HasMany
    {
        return $this->hasMany(EmploymentRecord::class)
                    ->where('is_current', true);
    }

    public function feedback(): HasMany
    {
        return $this->hasMany(ProfessionalFeedback::class)
                    ->where('is_published', true)
                    ->where('moderation_status', 'approved');
    }

    public function verificationRequests(): HasMany
    {
        return $this->hasMany(VerificationRequest::class);
    }

    // ── Accessors ────────────────────────────────────────────

    public function getFullNameAttribute(): string
    {
        return trim("{$this->first_name} {$this->middle_name} {$this->last_name}");
    }

    public function getMaskedNationalIdAttribute(): string
    {
        return substr($this->national_id, 0, 4)
            . str_repeat('*', strlen($this->national_id) - 7)
            . substr($this->national_id, -3);
    }

    public function getAverageRatingAttribute(): ?float
    {
        $avg = $this->feedback()->avg('rating_overall');
        return $avg ? round($avg, 1) : null;
    }

    public function getTotalExperienceYearsAttribute(): float
    {
        return $this->employmentRecords
            ->sum(function ($record) {
                $end = $record->end_date ?? now();
                return $record->start_date->diffInMonths($end) / 12;
            });
    }

    // ── Scopes ───────────────────────────────────────────────

    public function scopeVerified($query)
    {
        return $query->where('nida_verified', true);
    }

    public function scopeSearchable($query)
    {
        return $query->where('is_searchable', true)
                     ->where('profile_complete', true);
    }
}