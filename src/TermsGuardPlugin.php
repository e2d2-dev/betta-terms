<?php

namespace Betta\Terms;

use Closure;
use Filament\Contracts\Plugin;
use Filament\Panel;

class TermsGuardPlugin implements Plugin
{
    public function getId(): string
    {
        return 'betta-terms-guard';
    }

    public function register(Panel $panel): void
    {
        $panel
            ->pages([
                Terms::getConsentPageComponent(),
            ])
            ->authMiddleware([
                Terms::getPanelConsentMiddleware(),
            ]);
    }

    public function boot(Panel $panel): void
    {
        //
    }

    public static function make(): static
    {
        return app(static::class);
    }

    public function generateConsentConditionsHeadingUsing(Closure $callback): static
    {
        Terms::getConsentPageComponent()::generateHeadingUsing($callback);

        return $this;
    }

    public function disableGuard(Closure | bool $condition): static
    {
        Terms::disableGuard($condition);
        return $this;
    }
}
