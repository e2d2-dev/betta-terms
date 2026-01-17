<?php

namespace Betta\Terms\Filament\Forms\Concerns;

use Betta\Terms\Enums\Source;
use Betta\Terms\Models\Condition;
use Betta\Terms\Terms;
use Illuminate\Database\Eloquent\Model;

trait CanHaveConditionFromState
{
    protected function getConditionFromState(): Model
    {
        $repeaterState = $this->getParentRepeater()->getState();
        $keys = array_keys($repeaterState);
        $idx = $this->getParentRepeaterItemIndex();

        $key = $keys[$idx];

        $state = $repeaterState[$key];

        $model = Terms::getModel('condition');

        return new $model($state);
    }

    /**
     * @return Condition
     */
    protected function getConditionRecord(): Model
    {
        return $this->condition ??= $this->getConditionFromState();
    }

    public function getConditionDescription(): ?string
    {
        $recordDescription = $this->getConditionRecord()->description;

        if ($this->isCompact()) {
            return $recordDescription;
        }

        return in_array($this->getConditionSourceValue(), ['simple', 'link']) ? $recordDescription : null;
    }

    public function getConditionName(): ?string
    {
        return $this->getConditionRecord()->name;
    }

    public function getConditionSourceValue(): ?string
    {
        return $this->getConditionSource()->value;
    }

    public function getConditionSource(): Source
    {
        return $this->getConditionRecord()->source;
    }

    public function getRecord(bool $withContainerRecord = true): Model|array|null
    {
        $model = Terms::getModel('condition');

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
