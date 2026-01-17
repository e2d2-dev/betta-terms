<?php

namespace Betta\Terms\Models\Guard;

/**
 * @property ?string $slug
 */
trait HasSlug
{
    protected function initializeHasSlug(): void
    {
        $this->mergeFillable([
            'slug',
        ]);
    }

    public static function bySlug(string $slug): ?static
    {
        return static::query()->with('activeConditions')->where('slug', $slug)->first();
    }
}
