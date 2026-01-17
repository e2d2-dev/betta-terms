<?php

namespace Betta\Terms\Commands\Concerns;

trait AskToRunMigrations
{
    protected function askToRunMigrations(): void
    {
        if ($this->confirm('Should we run the migrations now?', true)) {
            $this->runCommand('migrate', [], $this->output);
        }
    }
}
