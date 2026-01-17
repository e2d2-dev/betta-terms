<?php

namespace Betta\Terms\Filament\Guards\Schemas\Components;

use Filament\Forms\Components\TextInput;

class CustomSlug extends TextInput
{
    public static function getDefaultName(): ?string
    {
        return 'custom_slug';
    }

    protected function setUp(): void
    {
        parent::setUp();

        $this->label('Slug');

        $this->visible(fn ($get) => $get('type') === 'custom');

        $this->required();
    }
}
