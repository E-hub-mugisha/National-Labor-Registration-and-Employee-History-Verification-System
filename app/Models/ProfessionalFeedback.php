<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ProfessionalFeedback extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'employment_record_id',
        'employee_id',
        'employer_id',
        'submitted_by',
        'rating_overall',
        'rating_punctuality',
        'rating_teamwork',
        'rating_communication',
        'rating_technical_skills',
        'rating_leadership',
        'rating_integrity',
        'rating_adaptability',
        'strengths',
        'areas_for_improvement',
        'general_comments',
        'would_rehire',
        'rehire_condition',
        'has_misconduct_flag',
        'misconduct_categories',
        'misconduct_details',
        'misconduct_legally_adjudicated',
        'misconduct_case_reference',
        'visibility',
        'is_published',
        'published_at',
        'employee_acknowledged',
        'employee_acknowledged_at',
        'employee_response',
        'moderation_status',
        'moderated_by',
        'moderated_at',
        'moderation_notes',
    ];

    protected $casts = [
        'has_misconduct_flag'            => 'boolean',
        'misconduct_categories'          => 'array',
        'misconduct_legally_adjudicated' => 'boolean',
        'would_rehire'                   => 'boolean',
        'is_published'                   => 'boolean',
        'published_at'                   => 'datetime',
        'employee_acknowledged'          => 'boolean',
        'employee_acknowledged_at'       => 'datetime',
        'moderated_at'                   => 'datetime',
    ];

    // ── Relationships ────────────────────────────────────────

    public function employmentRecord(): BelongsTo
    {
        return $this->belongsTo(EmploymentRecord::class);
    }

    public function employee(): BelongsTo
    {
        return $this->belongsTo(Employee::class);
    }

    public function employer(): BelongsTo
    {
        return $this->belongsTo(Employer::class);
    }

    public function submittedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'submitted_by');
    }

    public function moderatedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'moderated_by');
    }

    // ── Accessors ────────────────────────────────────────────

    public function getAverageRatingAttribute(): float
    {
        $fields = [
            'rating_overall',
            'rating_punctuality',
            'rating_teamwork',
            'rating_communication',
            'rating_technical_skills',
            'rating_integrity',
            'rating_adaptability',
        ];

        $values = array_filter(
            array_map(fn($f) => $this->$f, $fields)
        );

        return count($values)
            ? round(array_sum($values) / count($values), 1)
            : 0;
    }

    public function getRatingLabelAttribute(): string
    {
        return match(true) {
            $this->rating_overall >= 5 => 'Excellent',
            $this->rating_overall >= 4 => 'Good',
            $this->rating_overall >= 3 => 'Satisfactory',
            $this->rating_overall >= 2 => 'Below Expectations',
            default                    => 'Poor',
        };
    }

    // ── Scopes ───────────────────────────────────────────────

    public function scopePublished($query)
    {
        return $query->where('is_published', true)
                     ->where('moderation_status', 'approved');
    }

    public function scopePendingModeration($query)
    {
        return $query->where('moderation_status', 'pending');
    }

    public function scopeWithMisconduct($query)
    {
        return $query->where('has_misconduct_flag', true);
    }
}