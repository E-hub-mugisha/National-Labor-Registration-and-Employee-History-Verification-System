<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TransferRequest extends Model
{
    use HasFactory;

    protected $fillable = [
        'employee_id',
        'requesting_employer_id',
        'current_employer_id',
        'requested_position',
        'message',
        'status',
        'response_note',
        'responded_by',
        'responded_at',
        'requested_by',
    ];

    protected $casts = [
        'responded_at' => 'datetime',
    ];

    // ── Scopes ─────────────────────────────────────────────────────────────────
    public function scopePending($q)
    {
        return $q->where('status', 'pending');
    }
    public function scopeApproved($q)
    {
        return $q->where('status', 'approved');
    }

    public function getStatusBadgeAttribute(): string
    {
        return match ($this->status) {
            'pending'   => 'bg-amber-100 text-amber-800',
            'approved'  => 'bg-emerald-100 text-emerald-800',
            'rejected'  => 'bg-red-100 text-red-800',
            'cancelled' => 'bg-gray-100 text-gray-800',
            default     => 'bg-gray-100 text-gray-800',
        };
    }

    // ── Relationships ──────────────────────────────────────────────────────────
    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }
    public function requestingEmployer()
    {
        return $this->belongsTo(Employer::class, 'requesting_employer_id');
    }
    public function currentEmployer()
    {
        return $this->belongsTo(Employer::class, 'current_employer_id');
    }
    public function requestedBy()
    {
        return $this->belongsTo(User::class, 'requested_by');
    }
    public function respondedBy()
    {
        return $this->belongsTo(User::class, 'responded_by');
    }
}
