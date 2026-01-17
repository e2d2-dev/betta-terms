<?php

namespace Betta\Terms\Commands\Setup;

use Betta\Terms\ServiceProvider;

trait AskToPublishTranslations
{
    protected function askToPublishTranslations(): void
    {
        if (is_dir(lang_path('vendor/betta-terms'))) {
            $this->line('<fg=magenta>[</> Translations are already published... <fg=magenta> ]</>');

            return;
        }

        if ($this->ask('Would you like to publish translations?', 'yes')) {
            $this->runCommand('vendor:publish', ['--provider' => ServiceProvider::class, '--tag' => 'translations'], $this->output);
        }
    }
}
