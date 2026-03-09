<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class EmployeeSkill extends Model
{
    use HasFactory;

    protected $fillable = [
        'employee_id',
        'skill_name',
        'proficiency_level',
        'years_of_experience',
        'is_verified',
    ];

    protected $casts = [
        'is_verified' => 'boolean',
    ];

    // ── Relationships ────────────────────────────────────────

    public function employee(): BelongsTo
    {
        return $this->belongsTo(Employee::class);
    }

    // ── Accessors ────────────────────────────────────────────

    public function getProficiencyLabelAttribute(): string
    {
        return match($this->proficiency_level) {
            'beginner'     => 'Beginner',
            'intermediate' => 'Intermediate',
            'advanced'     => 'Advanced',
            'expert'       => 'Expert',
            default        => 'Unknown',
        };
    }

    // ── Scopes ───────────────────────────────────────────────

    public function scopeVerified($query)
    {
        return $query->where('is_verified', true);
    }
}