<?php

namespace Betta\Terms\Filament\Forms\Concerns;

use Closure;
use Illuminate\Validation\ValidationException;

trait HasValidationException
{
    protected null|Closure|bool $compactValidationException = null;

    public function compactValidationException(bool|Closure $condition = true): static
    {
        $this->compactValidationException = $condition;

        return $this;
    }

    protected function useCompactValidationException(): bool
    {
        return $this->evaluate($this->compactValidationException) ?? false;
    }

    protected function throwValidationException(): void
    {
        if (! $this->getUnAcceptedStateCollection()->count()) {
            return;
        }

        $this->useCompactValidationException()
            ? $this->throwCompactValidationException()
            : $this->throwFullValidationException();
    }

    protected function throwCompactValidationException(): void
    {
        throw ValidationException::withMessages([
            $this->getStatePath() => __('betta-terms::components.should_accept_terms.validation'),
        ]);
    }

    protected function throwFullValidationException(): void
    {
        $statePath = $this->getStatePath();
        $unAccepted = $this->getUnAcceptedStateCollection()
            ->keys()
            ->mapWithKeys(fn ($key) => ["{$statePath}.{$key}.accepted" => __('betta-terms::fields.term.validation.required')])
            ->toArray();

        throw ValidationException::withMessages($unAccepted);
    }
}
