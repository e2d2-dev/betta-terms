<?php

namespace Betta\Terms\Filament\Tables\Columns;

use Filament\Tables\Columns\TextColumn;

class SignedOnColumn extends TextColumn
{
    public static function getDefaultName(): ?string
    {
        return 'signed_on';
    }

    protected function setUp(): void
    {
        parent::setUp();

        $this->label(__('betta-terms::fields.signed_on.label'));
    }
}
