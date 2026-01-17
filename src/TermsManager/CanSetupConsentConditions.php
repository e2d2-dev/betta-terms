<?php

namespace Betta\Terms\TermsManager;

use Betta\Terms\Terms;

trait CanSetupConsentConditions
{
    public function setUpConsentConditions(): static
    {
        filament()->getCurrentPanel()
            ->topbar(Terms::getConfig('page.consent_conditions.topbar', false))
            ->globalSearch(Terms::getConfig('page.consent_conditions.global_search', false))
            ->navigation(Terms::getConfig('page.consent_conditions.global_search', false));

        return $this;
    }
}
