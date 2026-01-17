<?php

namespace Betta\Terms\Filament\Forms\Consent;

use Betta\Terms\Contracts\ModelConditions;
use Betta\Terms\Terms;
use Illuminate\Support\Collection;

trait HasGuardConditions
{
    protected function getGuardConditions(): Collection
    {
        $guard = $this->getApplicableGuard();

        if ($guard) {
            return Terms::getGuardConditions($guard);
        }

        return Terms::getComponentConditions($this->getLivewire());
    }

    protected function fillGuardConditions(): array
    {
        return $this->getGuardConditions()->toArray();
    }

    protected function implementsGuardConditions(): bool
    {
        return $this->getModelInstance() instanceof ModelConditions;
    }
}
