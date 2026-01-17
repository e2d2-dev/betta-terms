<?php

namespace Betta\Terms\Filament\Conditions\Tables\Columns;

use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\TextColumn;

class RevisionColumn extends TextColumn
{
    public static function getDefaultName(): ?string
    {
        return 'revision';
    }

    protected function setUp(): void
    {
        parent::setUp();

        $this->formatStateUsing(fn ($state) => $state === 1 ? __('betta-terms::entities.first.singular') : $state);

        $this->icon(fn ($state) => $state === 1 ? null : Heroicon::Hashtag);

        $this->label(__('betta-terms::entities.revision.singular'));
    }
}
