<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

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
        'phone',
        'email',
        'district',
        'province',
        'photo',
        'current_employer_id',
        'status',
        'skills',
        'highest_qualification',
    ];

    protected $casts = [
        'date_of_birth' => 'date',
        'skills'        => 'array',   // cast JSON column → array automatically
    ];

    // ── Accessors ──────────────────────────────────────────────────────────────

    public function getFullNameAttribute(): string
    {
        return trim("{$this->first_name} {$this->middle_name} {$this->last_name}");
    }

    public function getAgeAttribute(): int
    {
        return $this->date_of_birth->age;
    }

    /**
     * Returns a Bootstrap badge class instead of Tailwind.
     * Kept lean — no CSS framework logic in the model.
     * Use $employee->statusBadge in Blade.
     */
    public function getStatusLabelAttribute(): string
    {
        return match ($this->status) {
            'active'      => 'success',
            'unemployed'  => 'secondary',
            'blacklisted' => 'danger',
            default       => 'secondary',
        };
    }

    // ── Scopes ─────────────────────────────────────────────────────────────────

    public function scopeActive($q)
    {
        return $q->where('status', 'active');
    }

    public function scopeUnemployed($q)
    {
        return $q->where('status', 'unemployed');
    }

    // ── Relationships ──────────────────────────────────────────────────────────

    /**
     * FIXED: was belongsTo(User::class) but the controller calls
     * $employee->user()->create([...]) which only works on hasOne/hasMany.
     * The users table must have an `employee_id` foreign key column.
     */
    // ✅ To this
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function currentEmployer(): BelongsTo
    {
        return $this->belongsTo(Employer::class, 'current_employer_id');
    }

    public function employmentRecords(): HasMany
    {
        return $this->hasMany(EmploymentRecord::class)->orderBy('start_date', 'desc');
    }

    /**
     * The currently active employment record (no end date).
     */
    public function activeEmploymentRecord(): HasOne
    {
        return $this->hasOne(EmploymentRecord::class)
            ->whereNull('end_date')
            ->latestOfMany('start_date');
    }

    public function claims(): HasMany
    {
        return $this->hasMany(Claim::class);
    }

    public function transferRequests(): HasMany
    {
        return $this->hasMany(TransferRequest::class);
    }

    /**
     * The single pending transfer request (if any).
     */
    public function pendingTransferRequest(): HasOne
    {
        return $this->hasOne(TransferRequest::class)
            ->where('status', 'pending')
            ->latestOfMany();
    }

    // ── Helpers ────────────────────────────────────────────────────────────────

    public function isCurrentlyEmployedAt(Employer $employer): bool
    {
        return $this->current_employer_id === $employer->id;
    }

    public function hasPendingTransfer(): bool
    {
        return $this->transferRequests()->where('status', 'pending')->exists();
    }
}
