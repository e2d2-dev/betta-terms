<?php

namespace Betta\Terms\Commands\Setup;

use Betta\Terms\ServiceProvider;

trait AskToPublishConfig
{
    protected function askToPublishConfig(): void
    {
        if (file_exists(config_path('betta-terms.php'))) {
            $this->line('<fg=magenta>[</> Config is already published... <fg=magenta>]</>');

            return;
        }

        if ($this->ask('Would you like to publish the config file?', 'yes')) {
            $this->runCommand('vendor:publish', ['--provider' => ServiceProvider::class, '--tag' => 'config'], $this->output);
        }
    }
}
