<?php

namespace Betta\Terms\Models\Guard;

use Betta\Terms\Models\Guard;
use Betta\Terms\Terms;

trait HasPanel
{
    public static function byPanel(string $panel): ?Guard
    {
        return static::query()
            ->with('activeConditions')
            ->where('slug', Terms::getPanelSlug($panel))->first();
    }

    public function isPanel(): bool
    {
        return str($this->slug)->startsWith(Terms::getPanelSlugPrefix());
    }
}
