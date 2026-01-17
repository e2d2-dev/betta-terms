<?php

namespace Betta\Terms\Filament\Guards\Schemas\Components\Concerns;

use Betta\Terms\Enums\GuardType;

trait CanUpdateSlug
{
    public function updateSlug(): void
    {
        $type = $this->get('type');
        $panel = $this->get('panel');
        $name = $this->get('name');
        $component = $this->get('component');

        if (! $name and ! $component) {
            $this->set('slug', null);

            return;
        }

        $sluggable = match ($type) {
            GuardType::Custom => $name,
            default => false
        };

        if (! $sluggable) {
            return;
        }

        $slug = str($sluggable)
            ->replace(' ', '.')
            ->deduplicate('.')
            ->lower()
            ->when($panel, fn ($str) => $str->prepend($panel.'::'))
            ->toString();

        $this->set('slug', $slug);
    }

    public function set(string $statePath, mixed $value): void
    {
        $this->makeSetUtility()($statePath, $value);

    }

    public function get(string $statePath, bool $isAbsolute = false)
    {
        return $this->makeGetUtility()($statePath, isAbsolute: $isAbsolute);
    }
}
