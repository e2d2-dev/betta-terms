<?php

namespace Betta\Terms\Filament\Auth;

use Betta\Terms\Filament\Forms\ConsentPicker;
use Filament\Schemas\Schema;

class Register extends \Filament\Auth\Pages\Register
{
    public function form(Schema $schema): Schema
    {
        return $schema
            ->components($this->getComponents());
    }

    public function getComponents(): array
    {
        return [
            $this->getNameFormComponent(),
            $this->getEmailFormComponent(),
            $this->getPasswordFormComponent(),
            $this->getPasswordConfirmationFormComponent(),

            ConsentPicker::make()
                ->compact(),
        ];
    }
}
