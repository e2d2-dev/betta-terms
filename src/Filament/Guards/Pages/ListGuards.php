<?php

namespace Betta\Terms\Filament\Guards\Pages;

use Betta\Terms\Terms;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListGuards extends ListRecords
{
    public static function getResource(): string
    {
        return Terms::getGuardResource();
    }

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
