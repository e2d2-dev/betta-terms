<?php

namespace Betta\Terms\Filament\Tables\Columns;

use Filament\Tables\Columns\TextColumn;

class SourceColumn extends TextColumn
{
    public static function getDefaultName(): ?string
    {
        return 'source';
    }

    protected function setUp(): void
    {
        parent::setUp();

        $this->label(__('betta-terms::fields.source.label'));
    }
}
