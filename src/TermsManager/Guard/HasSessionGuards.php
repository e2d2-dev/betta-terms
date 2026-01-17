<?php

namespace Betta\Terms\TermsManager\Guard;

use Betta\Terms\Models\Guard;

trait HasSessionGuards
{
    public function clearSessionGuard(Guard $guard): static
    {
        $guards = array_flip($this->getSessionGuards());

        unset($guards[$guard->slug]);

        $this->session('guards', array_flip($guards));

        if ($guard->isPanel()) {
            $this->panelSessionComplete();
        }

        return $this;
    }

    public function getSessionGuards(): array
    {
        return $this->getSession('guards') ?? [];
    }

    public function getNextSessionGuard(): ?string
    {
        return $this->getSessionGuards()[0] ?? null;
    }

    public function hasNextSessionGuard(): bool
    {
        return (bool) $this->getNextSessionGuard();
    }

    public function sessionGuard(?string $guard = null): static
    {
        if ($guard) {
            $guards = array_unique(
                array_merge($this->getSessionGuards(), [$guard])
            );

            $this->session('guards', $guards);
        }

        return $this;
    }
}
