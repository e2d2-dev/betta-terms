<?php

namespace Betta\Terms\Filament\Forms\Concerns;

use Closure;

trait HasExcludes
{
    protected null|Closure|array $excludes = null;

    public function excludes(array|Closure $excludes): static
    {
        $this->excludes = $excludes;

        return $this;
    }

    public function getExcludes(): array
    {
        return $this->evaluate($this->excludes) ?? [];
    }

    public function hasExcludes(): bool
    {
        return ! empty($this->getExcludes());
    }
}
