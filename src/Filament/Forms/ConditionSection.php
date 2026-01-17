<?php

namespace Betta\Terms\Filament\Forms;

use Betta\Terms\Enums\Source;
use Betta\Terms\Filament\Forms\Actions\UrlAction;
use Betta\Terms\Filament\Forms\Concerns\CanHaveConditionFromState;
use Betta\Terms\Filament\Forms\Fields\EmbedField;
use Betta\Terms\Filament\Forms\Fields\TextField;
use Filament\Schemas\Components\Section;

class ConditionSection extends Section
{
    use CanHaveConditionFromState;

    protected function setUp(): void
    {
        parent::setUp();

        $this->heading(fn () => $this->getConditionName());

        $this->persistCollapsed();

        $this->collapsed();

        $this->visible(fn () => ! in_array($this->getConditionSource(), [Source::Simple, Source::Link]));

        $this->description(fn () => implode(' | ', array_filter([
            $this->getConditionRecord()->created_at->toFormattedDateString(),
            $this->getConditionDescription(),
        ])));

        $this->headerActions([
            fn () => $this->getConditionRecord() && $this->getConditionRecord()->hasUrl()
                ? UrlAction::make()->record($this->getConditionRecord())
                : null,
        ]);

        $this->schema(fn () => [
            EmbedField::make(),
            TextField::make(),
        ]);
    }
}
