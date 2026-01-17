<?php

namespace Betta\Terms\Filament\Tables\Columns;

use Filament\Tables\Columns\TextColumn;

class CreatedColumn extends TextColumn
{
    public static function getDefaultName(): ?string
    {
        return 'created_at';
    }

    protected function setUp(): void
    {
        parent::setUp();

        $this->label(__('betta-terms::fields.created.label'));

        $this->date();
    }
}
