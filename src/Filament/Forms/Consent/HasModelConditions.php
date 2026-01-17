<?php

namespace Betta\Terms\Filament\Forms\Consent;

use Betta\Terms\Actions\Model\UpdateConsentGuardConditions;
use Betta\Terms\Contracts\ModelConditions;
use Betta\Terms\Models\Condition;
use Illuminate\Support\Arr;

trait HasModelConditions
{
    protected array $modelConditionState;

    protected function saveModelConditions(): void
    {
        $conditions = $this->getStateCollection()->map(function (Condition $condition) {
            return $condition->slug;
        })->values()->toArray();

        UpdateConsentGuardConditions::run($this->getRecord(), $conditions);
    }

    protected function getConsentedState($condition): array
    {
        $accepted = false;
        $disabled = false;
        $recordState = $this->getRecordConditionState();

        if ($this->implementsGuardConditions()) {
            $accepted = in_array($condition['slug'], Arr::flatten($recordState));
            $disabled = in_array($condition['slug'], $recordState['committed'] ?? []);
        }

        return [
            'accepted' => $accepted,
            'disabled' => $disabled,
        ];
    }

    protected function getRecordConditionState(): array
    {
        /** @var ModelConditions $record */
        $record = $this->getRecord();

        return $this->modelConditionState ??= $record->getSavedGuardConditions();
    }
}
