<?php

namespace Betta\Terms\TermsManager\Panels;

use Betta\Terms\Models\Guard;

trait HasPanelGuard
{
    protected ?Guard $panelGuard = null;

    public function getPanelGuard(?string $panel = null): ?Guard
    {
        $panel = $panel ?: $this->getCurrentPanelId();

        return $this->panelGuard = Guard::byPanel($panel);
    }

    public function hasPanelGuard(): bool
    {
        return (bool) $this->getPanelGuard();
    }
}
