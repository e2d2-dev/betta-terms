<?php

namespace Betta\Terms\Filament\Guards\Tables\Columns\Concerns;

use Betta\Terms\Models\Condition;
use Illuminate\Database\Eloquent\Model;

/**
 * @method Condition getRecord()
 */
trait HasPredecessor
{
    /**
     * @param  Condition|null  $record
     */
    protected function hasActivePredecessor(?Model $record = null): bool
    {
        $record = $record ?? $this->getConditionRecord();

        return $record->hasPredecessor() and ! $record->predecessor->isObsolete();
    }

    protected function getConditionRecord(): ?Condition
    {
        $record = $this->getRecord();

        if ($record instanceof Condition) {
            return $record;
        }

        return $this->getLivewire()->getOwnerRecord();
    }
}
