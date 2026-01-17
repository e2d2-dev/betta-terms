<?php

namespace Betta\Terms\TermsManager;

use Betta\Terms\Filament\Conditions\ConditionResource;
use Betta\Terms\Filament\Consents\ConsentResource;
use Betta\Terms\Filament\Guards\GuardResource;

trait HasResources
{
    /**
     * @return class-string<GuardResource>
     */
    public function getGuardResource(): string
    {
        return $this->getConfig('resources.guard.component', GuardResource::class);
    }

    /**
     * @return class-string<ConditionResource>
     */
    public function getConditionResource(): string
    {
        return $this->getConfig('resources.condition.component', ConditionResource::class);
    }

    /**
     * @return class-string<ConsentResource>
     */
    public function getConsentResource(): string
    {
        return $this->getConfig('resources.consent.component', ConsentResource::class);
    }

    public function getResourceNavigationGroup(): string
    {
        return $this->getConfig('resources.group', 'betta-terms::nav.group');
    }
}
