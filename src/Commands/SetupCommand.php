<?php

namespace Betta\Terms\Commands;

use Betta\Onboarding\Commands\Concerns\AskToStar;
use Betta\Terms\Commands\Setup\InitializeTables;
use Betta\Terms\Commands\Setup\AskToPublishConfig;
use Betta\Terms\Commands\Setup\AskToPublishTranslations;
use Betta\Terms\Commands\Setup\HasConfig;
use Betta\Terms\ManageTermsPlugin;
use Betta\Terms\TermsGuardPlugin;
use Filament\Panel;
use Illuminate\Console\Command;

class SetupCommand extends Command
{
    use InitializeTables;
    use AskToPublishConfig;
    use AskToPublishTranslations;
    use AskToStar;
    use HasConfig;

    protected $description = 'Setup betta-terms';

    protected $name = 'terms:setup';

    public function handle(): int
    {
        $this->line('<fg=magenta>[</> Betta Terms Setup <fg=magenta>]</>');

        $this->panelInfo();

        $this->loadConfig();

        $this->askToPublishConfig();

        $this->askToPublishTranslations();

        $this->askToRunCreateTables();

        $this->askToStar();

        return static::SUCCESS;
    }

    public function panelInfo(): void
    {
        $manage = null;
        $guard = null;
        try {
            $manage = $this->hasPlugin('betta-manage-terms');
        } catch (\Exception $e) {}

        try {
            $guard = $this->hasPlugin('betta-terms-guard');
        } catch (\Exception $e) {}

        $managePlugin = ManageTermsPlugin::class;
        $guardPlugin = TermsGuardPlugin::class;

        if(!$manage || !$guard) {
            $this->line('Terms has two filament plugins: Management & Guard');
            $this->newLine();
        }
        if(!$manage) {
            $this->line('The Management Plugin will register management resources (3)');
            $this->warn("<fg=magenta>[</> The Plugin is not registered at any panel <fg=magenta>]</>");
            $this->line("Add <fg=yellow>$managePlugin</> to your panel provider in the plugin section");
            $this->newLine();
        } else {
            $this->line("<fg=magenta>[</> Management Plugin Registered <fg=red>@</><fg=green>{$manage}</> Panel <fg=magenta>]</>");
        }

        if(!$guard) {
            $this->line('The Guard Plugin will enable the guard middleware & the consent page');
            $this->warn("<fg=magenta>[</> The Plugin is not registered at any panel <fg=magenta>]</>");
            $this->line("Add <fg=yellow>$guardPlugin</> to your panel provider in the plugin section");
            $this->newLine();
        } else {
            $this->line("<fg=magenta>[</> Guard Plugin Registered <fg=red>@</><fg=green>{$guard}</> Panel<fg=magenta>]</>");
        }
    }

    protected function hasPlugin(string $plugin): ?string
    {
        return collect(filament()->getPanels())->filter(function (Panel $panel) use ($plugin) {
            return (bool)$panel->getPlugin($plugin);
        })
        ->map(fn(Panel $panel) => $panel->getId())->first();
    }
}
