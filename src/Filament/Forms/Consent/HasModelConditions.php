<?php

namespace Betta\Terms\Filament\Forms\Consent;

use Betta\Terms\Actions\Model\UpdateConsentGuardConditions;
use Betta\Terms\Contracts\ModelConditions;
use Betta\Terms\Contracts\UpdatesConsentGuardConditions;
use Betta\Terms\Models\Condition;
use Illuminate\Support\Arr;

trait HasModelConditions
{
    protected array $modelConditionState;

    protected function saveModelConditions(): void
    {
        $conditions = $this->getStateCollection()->map(function (array $condition) {
            return $condition['slug'];
        })->values()->toArray();

        app(UpdatesConsentGuardConditions::class)->update($this->getRecord(), $conditions);
    }

    protected function getModelConsentedState(Condition $condition): Condition
    {
        $accepted = false;
        $disabled = false;
        $state = $this->getModelConditionState();

        if ($this->implementsGuardConditions()) {
            $slug = $condition->slug;
            $accepted = in_array($slug, Arr::flatten($state));
            $disabled = in_array($slug, $state['committed'] ?? []);
        }

        $condition->accepted = $accepted;
        $condition->disabled = $disabled;

        return $condition;
    }

    protected function getModelConditionState(): array
    {
        /** @var ModelConditions $record */
        $record = $this->getRecord();

        return $this->modelConditionState ??= $record->getSavedGuardConditions();
    }
}
