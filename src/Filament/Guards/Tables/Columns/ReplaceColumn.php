<?php

namespace Betta\Terms\Filament\Guards\Tables\Columns;

use Betta\Terms\Models\Condition;
use Filament\Tables\Columns\TextColumn;

class ReplaceColumn extends TextColumn
{
    public static function getDefaultName(): ?string
    {
        return 'replace';
    }

    protected function setUp(): void
    {
        parent::setUp();

        $this->label(false);

        $this->replaceLabel();

        $this->replaceTooltip();

        $this->replaceColor();

        $this->badge();
    }

    public function replaceColor(): static
    {
        $this->color(function (Condition $record) {
            return match (true) {
                $record->willBeReplaced() => 'warning',
                $record->willReplace() => 'success',
                default => null,
            };
        });

        return $this;
    }

    public function replaceLabel(): static
    {
        $this->getStateUsing(function (Condition $record) {
            return match (true) {
                $record->willBeReplaced() => $record->successor->name,
                $record->willReplace() => $record->predecessor->name,
                default => null,
            };
        });

        return $this;
    }

    public function replaceTooltip(): static
    {
        $this->tooltip(function (Condition $record) {
            return match (true) {
                $record->willBeReplaced() => __('betta-terms::entities.successor.singular'),
                $record->willReplace() => __('betta-terms::entities.predecessor.plural'),
                default => null,
            };
        });

        return $this;
    }
}
