<?php

namespace Betta\Terms\Commands;

use Betta\Terms\Commands\Concerns\GuardStuff;
use Betta\Terms\Commands\Concerns\MigrationStuff;
use Betta\Terms\ModelRegistry;
use Betta\Terms\Terms;
use Illuminate\Console\Command;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use function Laravel\Prompts\search;

class MakeModelCommand extends Command
{
    use MigrationStuff;
    use GuardStuff;

    protected $description = 'Creates a betta-terms model-guard migration';

    protected $name = 'make:terms-model';

    protected $signature = 'make:terms-model {--model=}';
    protected string $model;
    protected string $table;
    protected string $column;


    public function handle(): int
    {
        $this->info('[ Betta Terms make:terms-model ]');
        $this->info('This will create a migration for the model guard');

        $this->askForModel();

        if(! $this->askForColumn()) {
            return static::FAILURE;
        };

        $this->createMigration();

        $this->askToCreateGuard();

        return static::SUCCESS;
    }

    protected function askToCreateGuard(): void
    {
        if($this->guardExists(Terms::getModelSlug($this->model))) {
            $this->error('exiting...');
            return;
        }

        $this->runCommand('make:terms-guard', [
            'name' => $this->getGuardName(),
            '--model' => $this->model,
        ], $this->output);
    }

    protected function getGuardName(): string
    {
        return str($this->model)
            ->classBasename()
            ->append(' Guard')
            ->toString();
    }

    protected function createMigration(): void
    {
        $content = str($this->getStub())
            ->replace('{{ table }}', $this->getTable())
            ->replace('{{ column }}', $this->column)
            ->toString();

        $name = $this->getTargetName();
        $target = $this->getFreshMigrationPath("$name.php");

        $this->line("Migration name: <fg=green>$name</>");

        if($this->checkForExistingMigration($name, true)) {
            return;
        };

        file_put_contents($target, $content);

        $this->line('Migration created <fg=green>successfully</>');
    }

    protected function getTargetName(): string
    {
        return str($this->getStubPath())
            ->basename('.stub')
            ->replace('some', $this->getTable())
            ->toString();
    }

    protected function getStubPath(): string
    {
        return __DIR__ . '/../../stubs/migrations/add_model_guard_to_some_table.stub';
    }
    protected function getStub(): string
    {
        return file_get_contents($this->getStubPath());
    }

    protected function askForModel(): void
    {
        $this->model = search(
            'Which Model?',
            fn(?string $search) => $this->getModelQuery($search)
        );
    }

    protected function getModelQuery(?string $search): array
    {
        return collect(ModelRegistry::make()->getAll())
            ->when(
                $search,
                fn(Collection $models) => $models->filter(fn(string $model) => str($model)->contains($search, true))
            )
            ->toArray();
    }

    protected function getModelInstance(): Model
    {
        return new $this->model;
    }

    protected function getTable(): string
    {
        return $this->table ??= $this->getModelInstance()->getTable();
    }

    protected function askForColumn(): bool
    {
        $this->column = $this->ask(
            'Which Column?',
            'conditions',
        );

        if($this->tableColumnExists($this->getTable(), $this->column)) {
            $this->error('Column already exists');

            if(! $this->ask('Choose another column?')) {
                return false;
            };
            $this->askForColumn();
        }
        return true;
    }
}
