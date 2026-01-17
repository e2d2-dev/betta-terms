<?php

namespace Betta\Terms\Filament\Forms\Fields;

use Betta\Terms\Enums\Source;
use Betta\Terms\Filament\Forms\Concerns\CanHaveConditionFromState;
use Betta\Terms\Models\Condition;
use Filament\Infolists\Components\TextEntry;
use Filament\Support\Enums\TextSize;

/**
 * @method Condition getRecord(bool $withDefault = true)
 */
class MarkdownField extends TextEntry
{
    use CanHaveConditionFromState;

    public static function getDefaultName(): ?string
    {
        return 'markdown';
    }

    protected function setUp(): void
    {
        parent::setUp();

        $this->html();

        $this->hiddenLabel();

        $this->markdown();

        $this->state(fn () => $this->getRecord()->getMarkdown());

        $this->visible(function () {
            return $this->getRecord()->source === Source::Markdown;
        });
    }
}
