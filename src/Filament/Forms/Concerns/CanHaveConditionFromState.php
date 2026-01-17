<?php

namespace Betta\Terms\Filament\Forms\Concerns;

use Betta\Terms\Enums\Source;
use Betta\Terms\Models\Condition;
use Betta\Terms\Terms;
use Illuminate\Database\Eloquent\Model;

trait CanHaveConditionFromState
{
    protected function getConditionFromState(): Condition
    {
        $state = $this->getConditionStateFromRepeater();

        return is_array($state)
            ? $this->hydrateConditionFromState($state)
            : $state;
    }

    private function getConditionStateFromRepeater(): array|Condition
    {
        $repeaterState = $this->getParentRepeater()->getState();

        $keys = array_keys($repeaterState);
        $idx = $this->getParentRepeaterItemIndex();

        $key = $keys[$idx];

        return $repeaterState[$key];
    }

    private function hydrateConditionFromState(array $state): Condition
    {
        $condition = Terms::getConditionModel()::fromArray($state);
        $config = Terms::getConditionGuardModel()::fromArray($state['guard_config']);

        return $condition->setRelation('guardConfig', $config);
    }

    protected function getConditionRecord(): Condition
    {
        return $this->condition ??= $this->getConditionFromState();
    }

    public function getConditionDescription(): ?string
    {
        $recordDescription = $this->getConditionRecord()->description;

        if ($this->isCompact()) {
            return $recordDescription;
        }

        return in_array($this->getConditionSource(), [Source::Simple, Source::Link]) ? $recordDescription : null;
    }

    public function getConditionName(): ?string
    {
        return $this->getConditionRecord()->name;
    }

    public function getConditionSource(): ?Source
    {
        return $this->getConditionRecord()->source;
    }

    public function getRecord(bool $withContainerRecord = true): Model|array|null
    {
        $model = Terms::getConditionModel();

        $record = parent::getRecord($withContainerRecord);

        return $record instanceof $model
            ? $record
            : $this->getConditionRecord();
    }

    public function isSimple(): bool
    {
        return in_array($this->getConditionSource(), [Source::Simple, Source::Link]);
    }
}
