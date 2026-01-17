<?php

namespace Betta\Terms\Contracts;

use Betta\Terms\Models\Condition;

interface CanConsent
{
    public function consentCondition(Condition $condition, ?string $signedOn = null): static;
}
