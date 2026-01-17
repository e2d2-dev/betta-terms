<?php

namespace Betta\Terms\Filament\Conditions\Forms;

use Filament\Forms\Components\TextInput;

class NameInput extends TextInput
{
    public static function getDefaultName(): ?string
    {
        return 'name';
    }

    protected function setUp(): void
    {
        parent::setUp();

        $this->maxLength(100);

        $this->label(__('betta-terms::fields.name.label'));

        $this->required();
    }
}
