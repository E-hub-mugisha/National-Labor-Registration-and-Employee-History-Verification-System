<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Employer extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'user_id',
        'name',
        'tin_number',
        'registration_number',
        'sector',
        'address',
        'district',
        'province',
        'phone',
        'email',
        'website',
        'logo',
        'status',
        'rejection_reason',
        'verified_by',
        'verified_at',
        'description',
    ];

    protected $casts = [
        'verified_at' => 'datetime',
    ];

    // ── Scopes ─────────────────────────────────────────────────────────────────
    public function scopeVerified($q)
    {
        return $q->where('status', 'verified');
    }
    public function scopePending($q)
    {
        return $q->where('status', 'pending');
    }

    // ── Status helpers ─────────────────────────────────────────────────────────
    public function isVerified(): bool
    {
        return $this->status === 'verified';
    }
    public function isPending(): bool
    {
        return $this->status === 'pending';
    }
    public function isSuspended(): bool
    {
        return $this->status === 'suspended';
    }

    public function getStatusBadgeAttribute(): string
    {
        return match ($this->status) {
            'verified'  => 'bg-emerald-100 text-emerald-800',
            'pending'   => 'bg-amber-100 text-amber-800',
            'suspended' => 'bg-red-100 text-red-800',
            'rejected'  => 'bg-gray-100 text-gray-800',
            default     => 'bg-gray-100 text-gray-800',
        };
    }

    // ── Relationships ──────────────────────────────────────────────────────────
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function currentEmployees()
    {
        return $this->hasMany(Employee::class, 'current_employer_id');
    }

    public function employmentRecords()
    {
        return $this->hasMany(EmploymentRecord::class);
    }

    public function activeEmploymentRecords()
    {
        return $this->employmentRecords()->whereNull('end_date');
    }

    public function transferRequestsReceived()
    {
        return $this->hasMany(TransferRequest::class, 'current_employer_id');
    }

    public function transferRequestsSent()
    {
        return $this->hasMany(TransferRequest::class, 'requesting_employer_id');
    }

    // ── Accessors ──────────────────────────────────────────────────────────────
    public function getSectorLabelAttribute(): string
    {
        return match ($this->sector) {
            'public_administration' => 'Public Administration',
            'banking_finance'       => 'Banking & Finance',
            'hospitality_tourism'   => 'Hospitality & Tourism',
            'bpo_call_center'       => 'BPO / Call Center',
            'healthcare'            => 'Healthcare',
            'education'             => 'Education',
            'manufacturing'         => 'Manufacturing',
            'construction'          => 'Construction',
            'agriculture'           => 'Agriculture',
            'ngo'                   => 'NGO / Non-Profit',
            'technology'            => 'Technology',
            'retail'                => 'Retail',
            default                 => 'Other',
        };
    }
}
