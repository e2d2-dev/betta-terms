<?php

namespace Betta\Terms;

use Filament\Contracts\Plugin;
use Filament\Panel;

class ManageTermsPlugin implements Plugin
{
    public function getId(): string
    {
        return 'betta-manage-terms';
    }

    public function register(Panel $panel): void
    {
        $panel
            ->resources([
                Terms::getGuardResource(),
                Terms::getConditionResource(),
                Terms::getConsentResource(),
            ]);
    }

    public function boot(Panel $panel): void {}

    public function registerModel(string $class, ?string $name): static
    {
        ModelRegistry::make()->add($class, $name);

        return $this;
    }

    public static function make(): static
    {
        return app(static::class);
    }
}
