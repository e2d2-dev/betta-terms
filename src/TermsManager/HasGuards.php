<?php

namespace Betta\Terms\TermsManager;

use Betta\Terms\Models\Condition;
use Betta\Terms\Models\Guard;
use Betta\Terms\Terms;
use Betta\Terms\TermsManager\Guard\HasSessionGuards;
use Illuminate\Database\Eloquent\Model;

trait HasGuards
{
    use HasSessionGuards;

    public function getGuardConditions(null|string|Model $guard): array
    {
        if (! $guard) {
            return [];
        }
        /** @var Guard $guard */
        $guard = is_string($guard) ? Guard::bySlug($guard) : $guard;

        $consentedIds = $this->getConsentConditionIds();

        return $guard
            ->activeConditions
            ->whereNotIn('id', $consentedIds)
            ->toArray();
    }

    public function getComponentConditions($component): array
    {
        if (! $component) {
            return [];
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
        return Terms::getModel('guard')::bySlug($slug);
    }

    public function getGuard(): ?Guard
    {
        return $this->getSessionGuard();
    }

    public function getGuardList(): array
    {
        return Terms::getModel('guard')::query()->pluck('name', 'slug')->toArray();
    }

    public function hasGuards(): bool
    {
        return Terms::getModel('guard')::query()->count() > 0;
    }
}
