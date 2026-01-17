<?php

namespace Betta\Terms\TermsManager;

use Betta\Terms\Models\Guard;

trait HasSession
{
    public function getSessionKey(): string
    {
        return $this->getConfig('betta-terms.session.key') ?? 'betta-terms';
    }

    public function getSession(string $key, mixed $default = null)
    {
        $value = session()->get("{$this->getSessionKey()}.{$key}");

        return $value ?? $default;
    }

    public function session(string $key, mixed $value): static
    {
        session()->put("{$this->getSessionKey()}.{$key}", $value);

        return $this;
    }

    public function getSessionGuard(): ?Guard
    {
        if ($this->hasNextSessionGuard()) {
            return $this->getGuardBySlug($this->getNextSessionGuard());
        }

        return null;
    }
}
