<?php

namespace Betta\Terms\Contracts;

use Betta\Terms\Relations\HasModelGuard;
use Betta\Terms\Relations\ManyModelConditions;

interface ModelConditions
{
    public function consentGuard(): HasModelGuard;

    public function guardConditions(): ManyModelConditions;

    public function guardConditionsAttribute(): string;
}
