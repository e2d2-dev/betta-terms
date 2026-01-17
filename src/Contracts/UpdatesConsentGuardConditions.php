<?php

namespace Betta\Terms\Contracts;

interface UpdatesConsentGuardConditions
{
    public function update(ModelConditions $record, array $data): void;
}
