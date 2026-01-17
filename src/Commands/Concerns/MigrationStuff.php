<?php

namespace Betta\Terms\Commands\Concerns;

use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Schema;
use SplFileInfo;

trait MigrationStuff
{
    use AskToRunMigrations;

    protected function prefixMigrationTimeStamp(string $filename): string
    {
        return date('Y_m_d_His_').$filename;
    }

    protected function getMigrationStubPath(?string $filename): string
    {
        return implode(DIRECTORY_SEPARATOR, array_filter([
            __DIR__.'/../../../stubs/migrations',
            $filename,
        ]));
    }

    protected function getMigrationStoragePath(?string $filename, bool $timestamp = false): string
    {
        $filename = $timestamp ? $this->prefixMigrationTimeStamp($filename) : null;

        return database_path(implode(DIRECTORY_SEPARATOR, [
            'migrations',
            $filename,
        ]));
    }

    protected function getFreshMigrationPath(string $name): string
    {
        return $this->getMigrationStoragePath($name, true);
    }

    protected function checkForExistingMigration($name, bool $exitWarning = false): bool
    {
        $exists = collect(File::files(database_path('migrations')))
            ->filter(fn(SplFileInfo $file) => str($file->getFilename())->contains($name))
            ->isNotEmpty();

        if($exists) {
            $this->line('Similar migration <fg=red>already</> exists!');
            $this->line('   -> Migration <fg=red>not</> created...');
        }

        return $exists;
    }

    protected function tableColumnExists(string $table, string $column): bool
    {
        return Schema::hasColumn($table, $column);
    }
}
