<?php

namespace Betta\Terms\Filament\Conditions\Forms;

use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Section;
use Filament\Support\Icons\Heroicon;

class FileSettingsSection extends Section
{
    protected function setUp(): void
    {
        parent::setUp();

        $this->collapsed();

        $this->heading(__('betta-terms::components.file_settings.label'));

        $this->icon(Heroicon::ServerStack);

        $this->schema([
            TextEntry::make('disk')
                ->label(__('betta-terms::components.file_settings.disk'))
                ->inlineLabel()
                ->state(config('betta-terms.fields.file.disk')),
            TextEntry::make('directory')
                ->label(__('betta-terms::components.file_settings.directory'))
                ->inlineLabel()
                ->state(config('betta-terms.fields.file.directory')),
            TextEntry::make('visibility')
                ->label(__('betta-terms::components.file_settings.visibility'))
                ->inlineLabel()
                ->state(config('betta-terms.fields.file.visibility')),
        ]);

        $this->visible(fn ($get) => HasFileComponent::canHaveFile($get('source')) && $get('has_file'));
    }
}
