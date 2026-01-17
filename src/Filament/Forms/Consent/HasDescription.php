<?php

namespace Betta\Terms\Filament\Forms\Consent;

use Closure;

trait HasDescription
{
    protected Closure|string|null $description = null;

    public function description(string|null|Closure $description): static
    {
        $this->description = $description;

        return $this;
    }
}
