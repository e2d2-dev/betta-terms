<?php

namespace Betta\Terms\Actions\Model;

use Betta\Terms\Contracts\ModelConditions;
use Betta\Terms\Contracts\UpdatesConsentGuardConditions;

class UpdateConsentGuardConditions implements UpdatesConsentGuardConditions
{
    public function update(ModelConditions $record, array $data): void
    {
        $consent = ['consent' => array_unique(array_merge($record->getSavedGuardConditions('committed'), $data))];

        $record->updateQuietly([
            $record->guardConditionsAttribute() => array_merge($record->getSavedGuardConditions(), $consent),
        ]);
    }
}
