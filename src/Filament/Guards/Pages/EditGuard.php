<?php

namespace Betta\Terms\Filament\Guards\Pages;

use Betta\Terms\Filament\Guards\Actions\PreviewAction;
use Betta\Terms\Terms;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditGuard extends EditRecord
{
    public static function getResource(): string
    {
        return Terms::getGuardResource();
    }

    protected function getHeaderActions(): array
    {
        return [
            PreviewAction::make(),
            DeleteAction::make(),
        ];
    }
}
