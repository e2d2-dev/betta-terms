<?php

namespace Betta\Terms\Filament\Conditions\Forms;

use Filament\Forms\Components\TextInput;

class DescriptionInput extends TextInput
{
    public static function getDefaultName(): ?string
    {
        return 'description';
    }

    protected function setUp(): void
    {
        parent::setUp();

        $this->maxLength(100);

        $this->label(__('betta-terms::fields.description.label'));
    }
}
