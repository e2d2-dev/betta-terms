<?php

namespace Betta\Terms\Commands\Concerns;

use Illuminate\Support\Facades\Artisan;

trait AskToRunMigrations
{
    protected function askToRunMigrations(): void
    {
        if ($this->confirm('Should we run the migrations now?', true)) {
            Artisan::call('migrate');
        }
    }
}
