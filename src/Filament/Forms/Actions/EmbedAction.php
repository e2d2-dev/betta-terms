<?php

namespace Betta\Terms\Filament\Forms\Actions;

use Betta\Terms\Filament\Forms\Fields\EmbedField;
use Betta\Terms\Models\Condition;

/**
 * @method Condition getRecord(bool $withDefault = true)
 */
class EmbedAction extends BaseAction
{
    public static function getDefaultName(): ?string
    {
        return 'embed';
    }

    protected function setUp(): void
    {
        parent::setUp();

        $this->modalHeading(fn () => $this->getRecord()->name);

        $this->modalDescription(fn () => $this->getRecord()->description);

        $this->schema(fn () => [
            EmbedField::make(),
        ]);
    }
}
