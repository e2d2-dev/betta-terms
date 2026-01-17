<?php

namespace Betta\Terms\Filament\Conditions\Forms;

use Filament\Forms\Components\Toggle;

class SkippableToggle extends Toggle
{
    public static function getDefaultName(): ?string
    {
        return 'skippable';
    }

    protected function setUp(): void
    {
        parent::setUp();

        $this->onColor('success');

        $this->default(false);

        $this->label(__('betta-terms::fields.skippable.label'));
    }
}
