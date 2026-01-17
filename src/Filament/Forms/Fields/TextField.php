<?php

namespace Betta\Terms\Filament\Forms\Fields;

use Betta\Terms\Enums\Source;
use Betta\Terms\Filament\Forms\Concerns\CanHaveConditionFromState;
use Betta\Terms\Models\Condition;
use Filament\Infolists\Components\TextEntry;

/**
 * @method Condition getRecord(bool $withDefault = true)
 */
class TextField extends TextEntry
{
    use CanHaveConditionFromState;

    public static function getDefaultName(): ?string
    {
        return 'text';
    }

    protected function setUp(): void
    {
        parent::setUp();

        $this->html();

        $this->hiddenLabel();

        $this->state(fn () => $this->getRecord()->getText());

        $this->visible(function () {
            return $this->getRecord()->source === Source::Text;
        });
    }
}
