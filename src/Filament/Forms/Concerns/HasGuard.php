<?php

namespace Betta\Terms\Filament\Forms\Concerns;

use Betta\Terms\Contracts\ModelConditions;
use Betta\Terms\Models\Guard;
use Betta\Terms\Terms;
use Closure;
use Illuminate\Database\Eloquent\Model;

trait HasGuard
{
    protected null|Closure|string|Guard $guard = null;

    public function guard(string|Closure|Guard $guard): static
    {
        $this->guard = $guard;

        return $this;
    }

    public function hasGuard(): bool
    {
        return (bool) $this->getGuard();
    }

    /**
     * @return Guard|null
     */
    public function getGuard(): ?Model
    {
        $guard = $this->evaluate($this->guard);

        if (! $guard) {
            return null;
        }

        if ($guard instanceof Guard) {
            return $guard;
        }

        return Terms::getModel('guard')::bySlug($guard);
    }

    protected function getApplicableGuard(): ?Guard
    {
        return match (true) {
            $this->hasGuard() => $this->getGuard(),
            $this->implementsGuardConditions() => $this->throwWhenConsentGuardIsNotBound(),
            Terms::hasPanelGuard() => Terms::getPanelGuard(),
            default => null,
        };
    }

    protected function throwWhenConsentGuardIsNotBound(): ?Guard
    {
        /** @var ModelConditions $record */
        $record = $this->getRecord();
        $guard = $record->consentGuard;

        if (! $guard) {
            $model = $this->getModel();
            throw new \Exception("The Model $model implements GuardsConditions, however there is no guard specified for that model.");
        }

        return $guard;
    }
}
