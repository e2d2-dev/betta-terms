<?php

namespace Betta\Terms\Models\Condition\CanBeReplaced;

use Betta\Terms\Models\Condition;
use Betta\Terms\Terms;
use Illuminate\Database\Eloquent\Relations\HasOne;

/**
 * @property ?Condition $predecessor
 */
trait HasPredecessor
{
    public function predecessor(): HasOne
    {
        return $this->hasOne(Terms::getModel('condition'), 'successor_id', 'id');
    }

    public function hasPredecessor(): bool
    {
        return (bool) $this->predecessor;
    }
}
