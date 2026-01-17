<?php

namespace Betta\Terms\Commands\Concerns;

use Betta\Terms\Models\Guard;
use Betta\Terms\Terms;

trait GuardStuff
{
    protected function guardExists(?string $slug, bool $existWarning = false): bool
    {
        if(!$slug) return false;

        $guard = (bool)Terms::getModel('guard')::bySlug($slug);

        if($guard && $existWarning) {
            $this->line("Guard <fg=green>{$slug}</> <fg=red>already</> exists!");
            $this->line("   -> Guard <fg=red>not</> created...");
        }

        return $guard;
    }

    protected function createGuardRecord(string $name, string $slug): Guard
    {
        return Terms::getModel('guard')::create([
            'name' => $name,
            'slug' => $slug,
        ]);
    }
}
