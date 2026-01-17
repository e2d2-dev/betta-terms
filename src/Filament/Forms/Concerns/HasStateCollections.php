<?php

namespace Betta\Terms\Filament\Forms\Concerns;

use Illuminate\Support\Collection;

trait HasStateCollections
{
    protected function getStateCollection(): Collection
    {
        return collect($this->getState());
    }

    protected function getUnAcceptedStateCollection(): Collection
    {
        return $this->getStateCollection()->filter(function ($condition) {
            if ($condition['is_skippable'] ?? false) {
                return false;
            }
            $accepted = $condition['accepted'] ?? false;

            return ! $accepted;
        });
    }
}
