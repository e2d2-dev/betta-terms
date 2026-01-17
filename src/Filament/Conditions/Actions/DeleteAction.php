<?php

namespace Betta\Terms\Filament\Conditions\Actions;

class DeleteAction extends \Filament\Actions\DeleteAction
{
    protected function setUp(): void
    {
        parent::setUp();

        $this->tooltip(fn ($record) => ! $record->isDeletable()
            ? __('betta-terms::actions.delete.already_has_consents.tooltip') :
            null
        );

        $this->disabled(fn ($record) => ! $record->isDeletable());
    }
}
