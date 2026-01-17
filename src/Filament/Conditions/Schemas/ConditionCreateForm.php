<?php

namespace Betta\Terms\Filament\Conditions\Schemas;

use Betta\Terms\Filament\Conditions\Forms\DescriptionInput;
use Betta\Terms\Filament\Conditions\Forms\NameInput;
use Filament\Forms\Components\Hidden;
use Filament\Schemas\Schema;

class ConditionCreateForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->schema([
                Hidden::make('guard_id')->dehydrated(false),
                NameInput::make(),
                DescriptionInput::make(),
            ]);
    }
}
