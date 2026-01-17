<?php

namespace Betta\Terms\TermsManager;

use Betta\Terms\TermsManager\Panels\HasPanelGuard;
use Betta\Terms\TermsManager\Panels\HasPanelSlug;
use Filament\Facades\Filament;
use Filament\Panel;
use Illuminate\Support\Collection;

trait HasPanels
{
    use HasPanelGuard;
    use HasPanelSlug;

    public function panelSessionComplete(bool $condition = true, ?string $panel = null): static
    {
        $this->session($this->getPanelKey($this->getCurrentPanelId($panel), 'complete'), $condition);

        return $this;
    }

    public function getPanelKey(string $panel, string $key): string
    {
        return "panel.{$panel}.{$key}";
    }

    public function getCurrentPanelId(?string $panel = null): ?string
    {
        return $panel ?? filament()->getCurrentPanel()->getId();
    }

    public function isPanelSessionComplete(?string $panel = null): bool
    {
        return (bool) $this->getSession($this->getPanelKey($this->getCurrentPanelId($panel), 'complete'));
    }

    public function panelMustConsent(): bool
    {
        if ($this->isPanelSessionComplete()) {
            return false;
        }

        $guard = $this->getPanelGuard();

        if (! $guard) {
            $this->panelSessionComplete();

            return false;
        }

        $mustConsent = $guard->authHasOpenConsents();

        if ($mustConsent) {
            $this->sessionGuard($guard->slug);
        } else {
            $this->panelSessionComplete();
        }

        return $mustConsent;
    }

    public function listPanels(): Collection
    {
        return collect(Filament::getPanels())->mapWithKeys(fn (Panel $panel) => [
            $panel->getId() => ucfirst($panel->getId()),
        ]);
    }
}
