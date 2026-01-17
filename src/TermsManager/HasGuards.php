<?php

namespace Betta\Terms\TermsManager;

use Betta\Terms\Models\Guard;
use Betta\Terms\Terms;
use Betta\Terms\TermsManager\Guard\HasSessionGuards;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

trait HasGuards
{
    use HasSessionGuards;

    public function getGuardConditions(null|string|Model $guard): Collection
    {
        if (! $guard) {
            return collect();
        }
        /** @var Guard $guard */
        $guard = is_string($guard) ? Guard::bySlug($guard) : $guard;

        $consentedIds = $this->getConsentConditionIds();

        return $guard
            ->activeConditions()
            ->whereNotIn('id', $consentedIds)
            ->orWherePivot('is_persistent', true)
            ->get();
    }

    public function getComponentConditions($component): Collection
    {
        if (! $component) {
            return collect();
        }

        if (is_object($component)) {
            $component = get_class($component);
        }

        $guess = str($component)
            ->classBasename()
            ->snake()
            ->prepend('component//')
            ->toString();

        return $this->getGuardConditions($guess);
    }

    public function getGuardBySlug(string $slug): ?Guard
    {
        return Terms::getGuardModel()::bySlug($slug);
    }

    public function getGuard(): ?Guard
    {
        return $this->getSessionGuard();
    }

    public function getGuardList(): array
    {
        return Terms::getGuardModel()::query()->pluck('name', 'slug')->toArray();
    }

    public function hasGuards(): bool
    {
        return Terms::getGuardModel()::query()->count() > 0;
    }
}
