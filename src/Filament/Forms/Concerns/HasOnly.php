<?php

namespace Betta\Terms\Filament\Forms\Concerns;

use Closure;

trait HasOnly
{
    protected null|Closure|array $only = null;

    public function only(array|Closure $only): static
    {
        $this->only = $only;

        return $this;
    }

    public function getOnly(): array
    {
        return $this->evaluate($this->only) ?? [];
    }

    public function hasOnly(): bool
    {
        return ! empty($this->getOnly());
    }
}
