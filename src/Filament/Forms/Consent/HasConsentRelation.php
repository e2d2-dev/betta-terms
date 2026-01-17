<?php

namespace Betta\Terms\Filament\Forms\Consent;

trait HasConsentRelation
{
    public function getConsentRelationName(): ?string
    {
        $state = $this->getState();

        if (! empty($state)) {
            return null;
        }

        if ($this->implementsGuardConditions()) {
            return 'guardConditions';
        }

        return null;
    }
}
