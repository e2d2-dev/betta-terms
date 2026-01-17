<?php

namespace Betta\Terms\Models\Guard;

use Betta\Terms\Models\ConditionGuard;
use Betta\Terms\Terms;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

/**
 * @property Collection $conditions
 * @property Collection $activeConditions
 * @property ConditionGuard $conditionConfig
 */
trait HasConditions
{
    public function conditions(): BelongsToMany
    {
        return $this->belongsToMany(
            Terms::getConditionModel(),
            Terms::getTable('condition_guard_config')
        )
            ->withPivot(['order', 'is_active', 'is_persistent', 'is_skippable'])
            ->withTimestamps()
            ->using(Terms::getConditionGuardModel())
            ->as('guardConfig')
            ->orderBy('order');
    }

    public function activeConditions(): BelongsToMany
    {
        return $this->conditions()
            ->whereNotNull('source')
            ->wherePivot('is_active', true);
    }
}
