<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AuditLog extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'action',
        'model_type',
        'model_id',
        'old_values',
        'new_values',
        'ip_address',
        'user_agent',
        'description',
    ];

    protected $casts = [
        'old_values' => 'array',
        'new_values' => 'array',
    ];

    // ── Relationships ────────────────────────────────────────

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    // ── Accessors ────────────────────────────────────────────

    public function getActionLabelAttribute(): string
    {
        return match($this->action) {
            'created'  => 'Created',
            'updated'  => 'Updated',
            'deleted'  => 'Deleted',
            'login'    => 'Logged In',
            'logout'   => 'Logged Out',
            'verified' => 'Verified',
            'searched' => 'Searched',
            default    => ucfirst($this->action),
        };
    }

    public function getChangeSummaryAttribute(): string
    {
        if (! $this->new_values) return 'No changes recorded';

        $changes = [];
        foreach ($this->new_values as $key => $value) {
            $old = $this->old_values[$key] ?? 'N/A';
            $changes[] = "{$key}: {$old} → {$value}";
        }

        return implode(', ', $changes);
    }

    // ── Scopes ───────────────────────────────────────────────

    public function scopeForModel($query, string $type, int $id)
    {
        return $query->where('model_type', $type)
                     ->where('model_id', $id);
    }

    public function scopeByAction($query, string $action)
    {
        return $query->where('action', $action);
    }

    public function scopeToday($query)
    {
        return $query->whereDate('created_at', today());
    }

    // ── Static Helpers ───────────────────────────────────────

    public static function record(
        string $action,
        string $description,
        ?Model $model = null,
        array $oldValues = [],
        array $newValues = []
    ): self {
        return self::create([
            'user_id'     => auth()->id(),
            'action'      => $action,
            'model_type'  => $model ? get_class($model) : null,
            'model_id'    => $model?->id,
            'old_values'  => $oldValues ?: null,
            'new_values'  => $newValues ?: null,
            'ip_address'  => request()->ip(),
            'user_agent'  => request()->userAgent(),
            'description' => $description,
        ]);
    }
}
