<?php

namespace Betta\Terms\Filament\Conditions\Forms;

use Betta\Terms\Enums\Source;
use Betta\Terms\Models\Condition;
use Filament\Forms\Components\Select;

class SourceComponent extends Select
{
    public static function getDefaultName(): ?string
    {
        return 'source';
    }

    protected function setUp(): void
    {
        parent::setUp();

        // $this->label(__('betta-terms::fields.source.label'));

        $this->hiddenLabel();

        $this->reactive();

        $this->options(Source::class);

        $this->disabled(fn (?Condition $record) => $record && $record->onceAccepted());
    }
}
