<?php

namespace Betta\Terms\Models\Condition\CanBeReplaced;

use Betta\Terms\Contracts\ActivatesSuccessor;
use Betta\Terms\Models\Condition;
use Betta\Terms\Terms;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property ?Condition $successor
 */
trait HasSuccessor
{
    protected function initializeHasSuccessor(): void
    {
        $this->mergeFillable([
            'successor_id',
        ]);
    }

    public function activateSuccessor(): void
    {
        app(ActivatesSuccessor::class)->activate($this);
    }

    public function hasSuccessor(): bool
    {
        return (bool) $this->successor;
    }

    public function successor(): BelongsTo
    {
        return $this->belongsTo(Terms::getConditionModel(), 'successor_id');
    }

    public function isSuccessor(): bool
    {
        return ! $this->hasSuccessor();
    }
}
