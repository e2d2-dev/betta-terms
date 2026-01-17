<?php

namespace Betta\Terms\TermsManager\Url;

trait HasIntendedUrl
{
    public function intendedUrl(?string $url = null): static
    {
        $this->session('intended_url', $url);

        return $this;
    }

    public function getIntendedUrl(): ?string
    {
        return $this->getSession('intended_url');
    }

    public function clearIntendedUrl(): static
    {
        $this->session('intended_url', null);

        return $this;
    }

    public function hasIntendedUrl(): bool
    {
        return $this->getIntendedUrl() !== null;
    }
}
