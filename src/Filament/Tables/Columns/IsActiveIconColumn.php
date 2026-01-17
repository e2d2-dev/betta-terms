<?php

namespace Betta\Terms\Filament\Tables\Columns;

use Filament\Tables\Columns\IconColumn;

class IsActiveIconColumn extends IconColumn
{
    public static function getDefaultName(): ?string
    {
        return 'is_active';
    }

    protected function setUp(): void
    {
        parent::setUp();

        $this->label(__('betta-terms::fields.is_active.label'));

        $this->boolean();
    }
}
