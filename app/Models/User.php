<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable, SoftDeletes;

    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'is_active',
        'avatar',
        'last_login_at',
    ];

    protected $hidden = ['password', 'remember_token'];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'last_login_at'     => 'datetime',
        'password'          => 'hashed',
        'is_active'         => 'boolean',
    ];

    // ── Role helpers ──────────────────────────────────────────────────────────
    public function isEmployee(): bool
    {
        return $this->role === 'employee';
    }
    public function isEmployer(): bool
    {
        return $this->role === 'employer';
    }
    public function isGovernment(): bool
    {
        return $this->role === 'government';
    }

    // ── Relationships ─────────────────────────────────────────────────────────
    public function employee()
    {
        return $this->hasOne(Employee::class);
    }

    public function employer()
    {
        return $this->hasOne(Employer::class);
    }
}
