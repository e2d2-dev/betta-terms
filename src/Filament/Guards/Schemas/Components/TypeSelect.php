<?php

namespace Betta\Terms\Filament\Guards\Schemas\Components;

use Betta\Terms\Enums\GuardType;
use Filament\Forms\Components\ToggleButtons;

class TypeSelect extends ToggleButtons
{
    public static function getDefaultName(): ?string
    {
        return 'type';
    }

    protected function setUp(): void
    {
        parent::setUp();

        $this->hiddenLabel();

        $this->visibleOn('create');

        $this->columnSpanFull();

        $this->dehydrated(false);

        $this->inline();

        $this->reactive();

        $this->default(GuardType::Custom);

        $this->afterStateUpdated(function ($set) {
            $set('name', null);
            $set('slug', null);
        });

        $this->options(GuardType::class);
    }
}
