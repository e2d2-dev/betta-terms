<?php

namespace Betta\Terms\Filament\Tables\Columns;

use Filament\Tables\Columns\TextColumn;

class NameColumn extends TextColumn
{
    public static function getDefaultName(): ?string
    {
        return 'name';
    }

    protected function setUp(): void
    {
        parent::setUp();

        $this->label(__('betta-terms::fields.name.label'));
    }
}
