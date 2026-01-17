<?php

namespace Betta\Terms\Filament\Guards\Tables\Columns;

use Betta\Terms\Filament\Guards\Tables\Columns\Concerns\HasPredecessor;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables\Columns\ToggleColumn;

class IsSkippableToggleColumn extends ToggleColumn
{
    use HasPredecessor;

    public static function getDefaultName(): ?string
    {
        return 'is_skippable';
    }

    protected function setUp(): void
    {
        parent::setUp();

        $this->label(__('betta-terms::fields.skippable.label'));

        $this->alignEnd();

        $this->onColor('success');

        $this->disabled(fn () => $this->hasActivePredecessor());
    }
}
