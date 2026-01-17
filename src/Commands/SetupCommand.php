<?php

namespace Betta\Terms\Commands;

use Betta\Terms\Commands\Concerns\AskToStar;
use Betta\Terms\Commands\Setup\AskToPublishConfig;
use Betta\Terms\Commands\Setup\AskToPublishTranslations;
use Betta\Terms\Commands\Setup\HasConfig;
use Betta\Terms\Commands\Setup\InitializeTables;
use Betta\Terms\ManageTermsPlugin;
use Betta\Terms\TermsGuardPlugin;
use Betta\Terms\Traits\User\HasConsents;
use Filament\Panel;
use Illuminate\Console\Command;

class SetupCommand extends Command
{
    use AskToPublishConfig;
    use AskToPublishTranslations;
    use AskToStar;
    use HasConfig;
    use InitializeTables;

    protected $description = 'Setup betta-terms';

    protected $name = 'terms:setup';

    public function handle(): int
    {
        $this->line('<fg=magenta>[</> Betta Terms Setup <fg=magenta>]</>');

        if (! $this->usesHasConsentsTrait()) {
            $this->info('Trait not used');
            $this->info("Add the {$this->getUserConsentsTrait()} to your user model");
            // Wait here?!?
        }

        $this->panelInfo();

        $this->loadConfig();

        $this->askToPublishConfig();

        $this->askToPublishTranslations();

        $this->askToRunCreateTables();

        $this->askToStar();

        return static::SUCCESS;
    }

    protected function getUserConsentsTrait(): string
    {
        return HasConsents::class;
    }

    protected function usesHasConsentsTrait(): bool
    {
        $model = $this->getAuthModel();
        $instance = new $model;

        return in_array($this->getUserConsentsTrait(), class_uses_recursive($instance));
    }

    protected function getAuthModel(): string
    {
        return config('auth.providers.users.model');
    }

    public function panelInfo(): void
    {
        $manage = null;
        $guard = null;
        try {
            $manage = $this->hasPlugin('betta-manage-terms');
        } catch (\Exception $e) {
        }

        try {
            $guard = $this->hasPlugin('betta-terms-guard');
        } catch (\Exception $e) {
        }

        $managePlugin = ManageTermsPlugin::class;
        $guardPlugin = TermsGuardPlugin::class;

        if (! $manage || ! $guard) {
            $this->line('Terms has two filament plugins: Management & Guard');
            $this->newLine();
        }
        if (! $manage) {
            $this->line('The Management Plugin will register management resources (3)');
            $this->warn('<fg=magenta>[</> The Plugin is not registered at any panel <fg=magenta>]</>');
            $this->line("Add <fg=yellow>$managePlugin</> to your panel provider in the plugin section");
            $this->newLine();
        } else {
            $this->line("<fg=magenta>[</> Management Plugin Registered <fg=red>@</><fg=green>{$manage}</> Panel <fg=magenta>]</>");
        }

        if (! $guard) {
            $this->line('The Guard Plugin will enable the guard middleware & the consent page');
            $this->warn('<fg=magenta>[</> The Plugin is not registered at any panel <fg=magenta>]</>');
            $this->line("Add <fg=yellow>$guardPlugin</> to your panel provider in the plugin section");
            $this->newLine();
        } else {
            $this->line("<fg=magenta>[</> Guard Plugin Registered <fg=red>@</><fg=green>{$guard}</> Panel<fg=magenta>]</>");
        }
    }

    protected function hasPlugin(string $plugin): ?string
    {
        return collect(filament()->getPanels())->filter(function (Panel $panel) use ($plugin) {
            return (bool) $panel->getPlugin($plugin);
        })
            ->map(fn (Panel $panel) => $panel->getId())->first();
    }
}
