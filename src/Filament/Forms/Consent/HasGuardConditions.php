<?php

namespace Betta\Terms\Filament\Forms\Consent;

use Betta\Terms\Contracts\ModelConditions;
use Betta\Terms\Terms;

trait HasGuardConditions
{
    protected function getGuardConditions(): array
    {
        $guard = $this->getApplicableGuard();

        if ($guard) {
            return Terms::getGuardConditions($guard);
        }

        return Terms::getComponentConditions($this->getLivewire());
    }

    protected function implementsGuardConditions(): bool
    {
        return $this->getModelInstance() instanceof ModelConditions;
    }
}
