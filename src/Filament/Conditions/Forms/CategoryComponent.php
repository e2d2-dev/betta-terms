<?php

namespace Betta\Terms\Filament\Conditions\Forms;

use Betta\Terms\Models\Condition;
use Filament\Forms\Components\ToggleButtons;

class CategoryComponent extends ToggleButtons
{
    public static function getDefaultName(): ?string
    {
        return 'category';
    }

    protected function setUp(): void
    {
        parent::setUp();

        $this->disabled(fn (?Condition $record) => $record?->hasConsents() || $record?->isObsolete() || $record?->hasPredecessor());

        $this->label(__('betta-terms::fields.category.label'));

        $this->inline();

        $this->multiple();

        $this->inlineLabel();

        // $this->options(Department::getAllWith('terms'));
    }
}
