<?php

namespace Betta\Terms\Filament\Forms\Concerns;

use Closure;

trait HasSignedOnSlug
{
    protected ?Closure $generateSignedOnSlugUsing = null;

    public function generateSignedOnSlugUsing(?Closure $callback = null): static
    {
        $this->generateSignedOnSlugUsing = $callback;

        return $this;
    }

    public function getGenerateSignedOnSlugUsing(): ?string
    {
        return $this->evaluate($this->generateSignedOnSlugUsing);
    }

    protected function getSignedOnSlug(): ?string
    {
        $using = $this->getGenerateSignedOnSlugUsing();

        $guard = $this->getApplicableGuard();

        if ($using) {
            return $using($this->getLivewire(), $this, $guard);
        }

        return $guard?->slug;
    }
}
