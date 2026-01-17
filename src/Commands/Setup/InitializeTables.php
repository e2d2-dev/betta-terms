<?php

namespace Betta\Terms\Commands\Setup;

use Betta\Terms\Commands\Concerns\AskToRunMigrations;
use Betta\Terms\Commands\Concerns\MigrationStuff;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Schema;

trait InitializeTables
{
    use AskToRunMigrations;
    use MigrationStuff;

    protected function askToRunCreateTables(): void
    {
        $tables = collect($this->config['tables']);

        $toMigrate = $tables->reject(fn ($table) => Schema::hasTable($table));

        if ($toMigrate->isEmpty()) {
            $this->line('<fg=magenta>[</> Tables are already migrated... <fg=magenta>]</>');

            return;
        }

        $this->info('Publishing migrations...');

        foreach ($toMigrate as $name => $table) {

            $stub = "create_{$table}_table.stub";

            $from = $this->getMigrationStubPath($stub);

            if (! $this->checkForExistingMigration($name, true)) {
                $to = $this->getMigrationStoragePath($stub, true);

                $content = File::get($from);

                File::put($to, $content);
            }
        }

        $this->askToRunMigrations();
    }
}
