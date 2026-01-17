<?php

namespace Betta\Terms\Filament\Pages\ConsentConditions\Actions;

use Filament\Actions\Action;

trait HasSaveAction
{
    public function getSaveAction(): Action
    {
        return Action::make('save')
            ->keyBindings(['command+s', 'ctrl+s'])
            ->color('success')
            ->label($this->getSaveActionLabel())
            ->action($this->getDoneLivewireActionName());
    }

    public function getDoneLivewireActionName(): string
    {
        return 'save';
    }

    public function getSaveActionLabel(): string|\Closure
    {
        return __('betta-terms::components.consent_conditions.actions.save.label');
    }
}
