<?php

namespace Betta\Terms\Models\Condition;

use Betta\Terms\Models\ConditionGuard;
use Betta\Terms\Models\Guard;
use Betta\Terms\Terms;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

/**
 * @property ?ConditionGuard $guardConfig
 */
trait HasGuards
{
    public function guards(): BelongsToMany
    {
        return $this->belongsToMany(Terms::getGuardModel(), Terms::getTable('condition_guard_config'))
            ->withTimestamps()
            ->using(Terms::getConditionGuardModel())
            ->as('conditionConfig')
            ->withPivot(['is_active', 'is_persistent', 'is_skippable', 'order']);
    }

    public function conditionGuard(): HasOne
    {
        return $this->hasOne(Terms::getConditionGuardModel());
    }

    public function scopeGuard(Builder $query, ?Guard $guard): void
    {
        $query->whereRelation('guards', 'id', $guard?->getKey());
    }
}
