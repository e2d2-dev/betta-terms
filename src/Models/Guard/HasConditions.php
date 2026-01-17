<?php

namespace Betta\Terms\Models\Guard;

use Betta\Terms\Terms;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

/**
 * @property Collection $conditions
 * @property Collection $activeConditions
 */
trait HasConditions
{
    public function conditions(): BelongsToMany
    {
        return $this->belongsToMany(
            Terms::getModel('condition'),
            Terms::getTable('condition_guard_pivot')
        )
            ->withPivot(['order', 'is_active', 'is_skippable'])
            ->orderBy('order');
    }

    public function activeConditions(): BelongsToMany
    {
        return $this->conditions()->wherePivot('is_active', true);
    }
}
