<?php

namespace Betta\Terms\Filament\Forms\Concerns;

use Betta\Terms\Terms;
use Illuminate\Support\Collection;

trait HasStateCollections
{
    protected function getStateCollection(): Collection
    {
        return collect($this->getState())->map(function ($item) {
            $model = Terms::getModel('condition');

            return new $model($item);
        });
    }

    protected function getUnAcceptedStateCollection(): Collection
    {
        return $this->getStateCollection()->filter(function ($condition) {
            if ($condition->isSkippable()) {
                return false;
            }

            return ! $condition->isAccepted();
        });
    }
}
