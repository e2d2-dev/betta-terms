<?php

namespace Betta\Terms\Filament\Conditions\Schemas\Sections;

use Betta\Terms\Filament\Forms\Fields\EmbedField;
use Betta\Terms\Filament\Forms\Fields\MarkdownField;
use Betta\Terms\Filament\Forms\Fields\TextField;
use Betta\Terms\Models\Condition;
use Filament\Schemas\Components\Section;
use Filament\Support\Icons\Heroicon;

/**
 * @method Condition getRecord(bool $withDefault = true)
 */
class PreviewSection extends Section
{
    protected function setUp(): void
    {
        parent::setUp();

        $this->visible(fn () => $this->getRecord()->hasValidSource());

        $this->collapsed();

        $this->icon(Heroicon::MagnifyingGlass);

        $this->heading(__('betta-terms::actions.preview.label'));

        $this->columnSpanFull();

        $this->schema([
            TextField::make(),
            MarkDownField::make(),
            EmbedField::make(),
        ]);
    }
}
