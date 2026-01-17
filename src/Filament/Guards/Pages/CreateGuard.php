<?php

namespace Betta\Terms\Filament\Guards\Pages;

use Betta\Terms\Terms;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\CreateRecord;
use Filament\Support\Exceptions\Halt;

class CreateGuard extends CreateRecord
{
    public static function getResource(): string
    {
        return Terms::getGuardResource();
    }

    public function afterValidate(): void
    {
        $slug = $this->form->getState()['slug'];

        if (static::getModel()::bySlug($slug)) {

            Notification::make()
                ->warning()
                ->title('This slug already exists.')
                ->body('record not created.')
                ->send();
            throw new Halt;
        }
    }
}
