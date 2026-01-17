<?php

namespace Betta\Terms\Filament\Forms\Consent;

use Closure;

trait HasLayout
{
    use HasDescription;
    use HasIcon;
    use HasLabel;

    protected Closure|bool|null $asSection = null;

    protected Closure|bool|null $aside = null;

    protected Closure|bool|null $compact = null;

    public function asSection(bool|Closure $condition = true): static
    {
        $this->asSection = $condition;

        return $this;
    }

    public function isSection(): bool
    {
        return (bool) $this->evaluate($this->asSection) || $this->isAside();
    }

    protected function getSectionLabel(): string
    {
        return $this->getChildComponents()[0]
            ->getChildComponents()[0]
            ->getStateLabel() ?? __('betta-terms::models.term.plural');
    }

    public function asSide(bool|Closure $condition = true): static
    {
        $this->aside = $condition;

        return $this;
    }

    public function isAside(): bool
    {
        return (bool) $this->evaluate($this->aside);
    }

    public function compact(bool|Closure $condition = true): static
    {
        $this->compact = $condition;

        return $this;
    }

    public function isCompact(): bool
    {
        return (bool) $this->evaluate($this->compact);
    }
}
