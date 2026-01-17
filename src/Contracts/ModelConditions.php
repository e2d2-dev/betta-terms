<?php

namespace Betta\Terms\Contracts;

use Betta\Terms\Relations\HasModelGuard;

interface ModelConditions
{
    public function guardConditionsAttribute(): string;

    public function consentGuard(): HasModelGuard;

    public function commitConsent(): void;
}
