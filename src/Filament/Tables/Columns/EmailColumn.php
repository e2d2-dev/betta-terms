<?php

namespace Betta\Terms\Filament\Tables\Columns;

use Filament\Tables\Columns\TextColumn;

class EmailColumn extends TextColumn
{
    public static function getDefaultName(): ?string
    {
        return 'email';
    }

    protected function setUp(): void
    {
        parent::setUp();

        $this->label(__('betta-terms::fields.email.label'));
    }
}
