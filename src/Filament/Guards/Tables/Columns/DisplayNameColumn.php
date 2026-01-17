<?php

namespace Betta\Terms\Filament\Guards\Tables\Columns;

use Filament\Tables\Columns\TextColumn;

class DisplayNameColumn extends TextColumn
{
    public static function getDefaultName(): ?string
    {
        return 'displayName';
    }

    protected function setUp(): void
    {
        parent::setUp();

        $this->label(__('betta-terms::fields.name.label'));

        $this->searchable([
            'name',
            'model',
        ]);
    }
}
