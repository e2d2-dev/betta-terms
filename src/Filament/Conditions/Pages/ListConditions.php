<?php

namespace Betta\Terms\Filament\Conditions\Pages;

use Betta\Terms\Terms;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListConditions extends ListRecords
{
    public static function getResource(): string
    {
        return Terms::getConditionResource();
    }

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
