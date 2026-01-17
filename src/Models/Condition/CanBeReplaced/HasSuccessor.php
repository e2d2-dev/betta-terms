<?php

namespace Betta\Terms\Models\Condition\CanBeReplaced;

use Betta\Terms\Actions\Condition\ActivateSuccessor;
use Betta\Terms\Models\Condition;
use Betta\Terms\Terms;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property ?Condition $successor
 */
trait HasSuccessor
{
    public function activateSuccessor(): void
    {
        ActivateSuccessor::run($this);
    }

    public function hasSuccessor(): bool
    {
        return (bool) $this->successor;
    }

    public function successor(): BelongsTo
    {
        return $this->belongsTo(Terms::getModel('condition'), 'successor_id');
    }

    public function isSuccessor(): bool
    {
        return ! $this->hasSuccessor();
    }
}
