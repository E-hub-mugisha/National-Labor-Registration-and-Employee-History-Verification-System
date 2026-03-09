<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Employer extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'user_id',
        'rdb_number',
        'company_name',
        'trading_name',
        'business_type',
        'industry_sector',
        'company_description',
        'website',
        'headquarters_province',
        'headquarters_district',
        'headquarters_address',
        'contact_phone',
        'contact_email',
        'hr_contact_name',
        'hr_contact_phone',
        'hr_contact_email',
        'verification_status',
        'verified_at',
        'verified_by',
        'rdb_verification_ref',
        'rejection_reason',
        'subscription_tier',
        'monthly_search_quota',
        'searches_used_this_month',
        'quota_reset_date',
        'company_logo',
        'is_active',
    ];

    protected $casts = [
        'verified_at'      => 'datetime',
        'quota_reset_date' => 'date',
        'is_active'        => 'boolean',
    ];

    // ── Relationships ────────────────────────────────────────

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function verifiedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'verified_by');
    }

    public function employmentRecords(): HasMany
    {
        return $this->hasMany(EmploymentRecord::class);
    }

    public function activeEmployees(): HasMany
    {
        return $this->hasMany(EmploymentRecord::class)
                    ->where('is_current', true);
    }

    public function feedback(): HasMany
    {
        return $this->hasMany(ProfessionalFeedback::class);
    }

    public function verificationRequests(): HasMany
    {
        return $this->hasMany(VerificationRequest::class);
    }

    // ── Accessors ────────────────────────────────────────────

    public function getDisplayNameAttribute(): string
    {
        return $this->trading_name ?? $this->company_name;
    }

    public function getIsVerifiedAttribute(): bool
    {
        return $this->verification_status === 'verified';
    }

    public function getRemainingSearchQuotaAttribute(): int
    {
        return max(0, $this->monthly_search_quota - $this->searches_used_this_month);
    }

    // ── Scopes ───────────────────────────────────────────────

    public function scopeVerified($query)
    {
        return $query->where('verification_status', 'verified')
                     ->where('is_active', true);
    }

    public function scopePending($query)
    {
        return $query->where('verification_status', 'pending');
    }

    // ── Methods ──────────────────────────────────────────────

    public function canSearch(): bool
    {
        return $this->is_verified
            && $this->remaining_search_quota > 0;
    }

    public function incrementSearchCount(): void
    {
        if ($this->quota_reset_date && now()->gt($this->quota_reset_date)) {
            $this->searches_used_this_month = 0;
            $this->quota_reset_date = now()->addMonth()->startOfMonth();
            $this->save();
        }
        $this->increment('searches_used_this_month');
    }
}