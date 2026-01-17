<?php

namespace Betta\Terms\Filament\Guards\Schemas\Components;

use Betta\Terms\Filament\Guards\Schemas\Components\Concerns\CanUpdateSlug;
use Filament\Forms\Components\TextInput;

class GuardNameInput extends TextInput
{
    use CanUpdateSlug;

    public static function getDefaultName(): ?string
    {
        return 'name';
    }

    protected function setUp(): void
    {
        parent::setUp();

        $this->maxLength(100);

        $this->reactive();

        $this->debounce('500ms');

        $this->required();

        $this->afterStateUpdated(fn () => $this->updateSlug());
    }
}
