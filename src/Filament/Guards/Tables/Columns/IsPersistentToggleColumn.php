<?php

namespace Betta\Terms\Filament\Guards\Tables\Columns;

use Filament\Tables\Columns\ToggleColumn;

class IsPersistentToggleColumn extends ToggleColumn
{
    public static function getDefaultName(): ?string
    {
        return 'is_persistent';
    }

    protected function setUp(): void
    {
        parent::setUp();

        $this->label(__('betta-terms::fields.persistent.label'));

        $this->alignEnd();

        $this->onColor('success');
    }
}
