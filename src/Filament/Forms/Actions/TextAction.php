<?php

namespace Betta\Terms\Filament\Forms\Actions;

use Betta\Terms\Models\Condition;
use Filament\Infolists\Components\TextEntry;

/**
 * @method Condition getRecord(bool $withDefault = true)
 */
class TextAction extends BaseAction
{
    public static function getDefaultName(): ?string
    {
        return 'text';
    }

    protected function setUp(): void
    {
        parent::setUp();

        $this->modalHeading(fn (Condition $record) => $record->name);

        $this->modalDescription(fn (Condition $record) => $record->description);

        $this->modalSubmitAction(fn (Condition $record, $action) => ! $record->hasUrl() ? false : $action);

        $this->schema(fn ($record) => [
            TextEntry::make('text')
                ->hiddenLabel()
                ->html(),
        ]);
    }
}
