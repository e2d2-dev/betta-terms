<?php

namespace Betta\Terms\Models;

use Betta\Terms\Terms;
use Betta\Terms\Traits\FromArray;
use Carbon\CarbonInterface;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\Pivot;

/**
 * @property Condition $condition
 * @property int $condition_id
 * @property Guard $guardRecord
 * @property int $guard_id
 * @property bool $is_active
 * @property bool $is_skippable
 * @property bool $is_persistent
 * @property int? $order
 * @property CarbonInterface $created_at
 * @property CarbonInterface $updated_at
 */
class ConditionGuard extends Pivot
{
    use FromArray;

    protected $fillable = [
        'condition_id',
        'guard_id',
        'is_active',
        'is_skippable',
        'is_persistent',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'is_skippable' => 'boolean',
        'is_persistent' => 'boolean',
    ];

    public function getTable()
    {
        return Terms::getTable('condition_guard_config');
    }

    public function guardRecord(): BelongsTo
    {
        return $this->belongsTo(Terms::getGuardModel());
    }

    public function condition(): BelongsTo
    {
        return $this->belongsTo(Terms::getConditionModel());
    }

    public function isSkippable(): bool
    {
        return $this->is_skippable;
    }

    public function isActive(): bool
    {
        return $this->is_active;
    }

    public function isPersistent(): bool
    {
        return $this->is_persistent;
    }
}
