<?php

namespace Betta\Terms\Filament\Tables\Columns;

use Betta\Terms\Models\Condition;
use Filament\Tables\Columns\TextColumn;

/**
 * @method Condition getRecord()
 */
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
