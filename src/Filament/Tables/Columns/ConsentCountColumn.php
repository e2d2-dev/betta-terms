<?php

namespace Betta\Terms\Filament\Tables\Columns;

use Filament\Tables\Columns\TextColumn;

class ConsentCountColumn extends TextColumn
{
    public static function getDefaultName(): ?string
    {
        return 'consents_count';
    }

    protected function setUp(): void
    {
        parent::setUp();

        $this->label(__('betta-terms::models.consent.plural'));

        $this->counts('consents');
    }
}
