<?php

namespace Betta\Terms\Filament\Forms\Consent;

use BackedEnum;
use Closure;

trait HasIcon
{
    protected string|Closure|null $icon = null;

    public function icon(string|null|Closure|BackedEnum $icon): static
    {
        $this->icon = $icon;

        return $this;
    }

    public function getIcon(): string|null|Closure|BackedEnum
    {
        return $this->evaluate($this->icon);
    }
}
