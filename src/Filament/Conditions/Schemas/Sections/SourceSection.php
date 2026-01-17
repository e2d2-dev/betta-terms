<?php

namespace Betta\Terms\Filament\Conditions\Schemas\Sections;

use Betta\Terms\Filament\Conditions\Forms\FileComponent;
use Betta\Terms\Filament\Conditions\Forms\FileSettingsSection;
use Betta\Terms\Filament\Conditions\Forms\HasFileComponent;
use Betta\Terms\Filament\Conditions\Forms\MarkdownComponent;
use Betta\Terms\Filament\Conditions\Forms\SourceComponent;
use Betta\Terms\Filament\Conditions\Forms\TextComponent;
use Betta\Terms\Filament\Conditions\Forms\UrlComponent;
use Betta\Terms\Models\Condition;
use Filament\Forms\Components\MarkdownEditor;
use Filament\Schemas\Components\Section;
use Filament\Support\Icons\Heroicon;

/**
 * @method Condition getRecord(bool $withContainerRecord = true)
 */
class SourceSection extends Section
{
    protected function setUp(): void
    {
        parent::setUp();

        $this->disabled(fn ($record) => $record?->hasConsents() || $record?->isObsolete());

        $this->columnSpanFull();

        $this->heading(__('betta-terms::fields.source.label'));

        $this->description(__('betta-terms::fields.source.description'));

        $this->icon(Heroicon::ArrowTopRightOnSquare);

        $this->iconColor(fn () => $this->getRecord()->hasValidSource() ? 'success' : 'warning');

        $this->columns();

        $this->schema([
            SourceComponent::make(),

            UrlComponent::make(),

            FileComponent::make(),
            HasFileComponent::make(),
            FileSettingsSection::make(),

            TextComponent::make(),
            MarkdownComponent::make(),
        ]);
    }
}
