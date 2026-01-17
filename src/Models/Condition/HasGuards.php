<?php

namespace Betta\Terms\Models\Condition;

use Betta\Terms\Terms;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

trait HasGuards
{
    public function guards(): BelongsToMany
    {
        return $this->belongsToMany(Terms::getModel('guard'), Terms::getTable('condition_guard_pivot'))
            ->withPivot(['is_active', 'is_skippable', 'order']);
    }

    public function conditionGuard(): HasOne
    {
        return $this->hasOne(Terms::getModel('condition_guard'));
    }
}
