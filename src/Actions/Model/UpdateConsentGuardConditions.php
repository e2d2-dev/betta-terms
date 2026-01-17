<?php

namespace Betta\Terms\Actions\Model;

use Betta\Terms\Contracts\ModelConditions;
use Lorisleiva\Actions\Concerns\AsAction;

class UpdateConsentGuardConditions
{
    use AsAction;

    public function handle(ModelConditions $record, array $data): void
    {
        $consent = ['consent' => array_unique(array_merge($record->getSavedGuardConditions('committed'), $data))];

        $record->updateQuietly([
            $record->guardConditionsAttribute() => array_merge($record->getSavedGuardConditions(), $consent),
        ]);
    }
}
