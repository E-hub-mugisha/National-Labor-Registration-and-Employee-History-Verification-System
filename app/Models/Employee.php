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

    public function getStatusBadgeAttribute(): string
    {
        return match ($this->status) {
            'active'      => 'bg-emerald-100 text-emerald-800',
            'unemployed'  => 'bg-gray-100 text-gray-800',
            'blacklisted' => 'bg-red-100 text-red-800',
            default       => 'bg-gray-100 text-gray-800',
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
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function currentEmployer()
    {
        return $this->belongsTo(Employer::class, 'current_employer_id');
    }

    public function employmentRecords()
    {
        return $this->hasMany(EmploymentRecord::class)->orderBy('start_date', 'desc');
    }

    public function activeEmploymentRecord()
    {
        return $this->hasOne(EmploymentRecord::class)->whereNull('end_date')->latest('start_date');
    }

    public function claims()
    {
        return $this->hasMany(Claim::class);
    }

    public function transferRequests()
    {
        return $this->hasMany(TransferRequest::class);
    }

    public function pendingTransferRequest()
    {
        return $this->hasOne(TransferRequest::class)->where('status', 'pending')->latest();
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
