<?php

namespace Betta\Terms\Filament\Guards\Schemas;

use Betta\Terms\Filament\Guards\Schemas\Components\CustomSlug;
use Betta\Terms\Filament\Guards\Schemas\Components\GuardNameInput;
use Betta\Terms\Filament\Guards\Schemas\Components\ModelSelect;
use Betta\Terms\Filament\Guards\Schemas\Components\PanelSelect;
use Betta\Terms\Filament\Guards\Schemas\Components\TypeSelect;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class GuardForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TypeSelect::make(),
                GuardNameInput::make(),

                TextInput::make('slug')
                    ->required()
                    ->disabledOn('edit')
                    ->maxLength(100),

                CustomSlug::make(),

                PanelSelect::make(),

                ModelSelect::make(),
            ]);
    }
}
