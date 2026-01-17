<?php

namespace Betta\Terms\Filament\Forms\Actions;

use Filament\Actions\Action;
use Filament\Support\Icons\Heroicon;

abstract class BaseAction extends Action
{
    protected function setUp(): void
    {
        parent::setUp();

        $this->icon(Heroicon::MagnifyingGlass);

        $this->iconSize('lg');

        $this->modalIcon(Heroicon::MagnifyingGlass);

        $this->iconButton();

        $this->modalSubmitAction(false);

        $this->modalCancelActionLabel(__('betta-terms::actions.close.label'));
    }
}
