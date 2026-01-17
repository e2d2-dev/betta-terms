<?php

namespace Betta\Terms\Filament\Forms\Consent;

use Closure;

trait HasLabel
{
    protected Closure|string|null $label = null;

    protected ?bool $hiddenLabel = null;

    public function label(string|null|Closure $label): static
    {
        $this->label = $label;

        return $this;
    }

    public function getLabel(): ?string
    {
        return $this->evaluate($this->label);
    }

    public function hiddenLabel($condition = true): static
    {
        $this->hiddenLabel = $condition;

        return $this;
    }

    public function isLabelHidden(): bool
    {
        return (bool) $this->evaluate($this->hiddenLabel);
    }
}
