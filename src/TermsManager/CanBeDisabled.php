<?php

namespace Betta\Terms\TermsManager;

use Betta\Terms\Traits\ResolveClosure;
use Closure;

trait CanBeDisabled
{
    use ResolveClosure;

    protected Closure|bool|null $disableGuard = null;

    protected Closure|bool|null $disableConsent = null;

    public function disableGuard(bool|Closure $condition): static
    {
        $this->disableGuard = $condition;

        return $this;
    }

    public function guardDisabled(): bool
    {
        $disabled = $this->disableGuard;

        if ($disabled instanceof Closure) {
            $disabled = $this->resolveClosure($disabled, [
                'manager' => $this,
                'panelGuard' => $this->getPanelGuard(),
            ]);
        }

        return (bool) $disabled;
    }

    public function disableConsent(bool|Closure $condition): static
    {
        $this->disableConsent = $condition;

        return $this;
    }

    public function consentDisabled(): bool
    {
        $disable = $this->disableConsent;

        if ($disable instanceof Closure) {
            $disable = $this->resolveClosure($disable, ['manager' => $this]);
        }

        return (bool) $disable;
    }
}
