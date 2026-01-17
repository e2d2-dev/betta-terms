<?php

namespace Betta\Terms\Commands;

use Betta\Terms\Commands\Concerns\CanAskToRestart;
use Betta\Terms\Commands\Concerns\GuardStuff;
use Betta\Terms\Enums\GuardType;
use Betta\Terms\ModelRegistry;
use Betta\Terms\Terms;
use Illuminate\Console\Command;
use Illuminate\Database\Eloquent\Model;

use function Laravel\Prompts\select;

class MakeGuardCommand extends Command
{
    use CanAskToRestart;
    use GuardStuff;

    protected $description = 'Create a betta-terms guard';

    protected $name = 'make:terms-guard';

    protected $signature = 'make:terms-guard {name?} {--model=}';

    protected ?string $type = null;

    protected string $guardName;

    protected ?string $slug = null;

    protected ?string $panel = null;

    protected ?string $model = null;

    protected ?Model $guard = null;

    public function handle(): int
    {
        if (! $this->option('model')) {
            $this->line('<fg=magenta>[</> Betta Terms make-guard <fg=magenta>]</>');

            $this->askForType();

            $this->askForModel();

            $this->askForPanel();
        }

        $this->setSlug();

        if ($this->guardExists($this->slug, true)) {
            if ($this->shouldRestart()) {
                $this->slug = null;
                $this->handle();
            }

            return static::FAILURE;
        }
        $this->askForGuardName();

        $this->createGuard();

        return static::SUCCESS;
    }

    protected function askForGuardName(): void
    {
        if ($this->type !== 'custom') {
            return;
        }

        $this->guardName = $this->ask('What should be the name of the guard?');
    }

    protected function setSlug(): void
    {
        if ($this->type === 'custom') {
            $choice = $this->ask('What should be the slug?');
            $this->slug = str($choice)->slug()->toString();
        }

        if ($this->getModel() || $this->type === 'model') {
            $this->slug = Terms::getModelSlug($this->getModel());
            $this->type = 'model';
        }

        if ($this->panel || $this->type === 'panel') {
            $this->slug = Terms::getPanelSlug($this->panel);
        }
        $this->info("<fg=magenta>Slug: </>{$this->slug}");
    }

    protected function getModel(): ?string
    {
        return $this->model ?? $this->option('model');
    }

    protected function askForType(): void
    {
        $options = collect(GuardType::cases())->mapWithKeys(function ($enum) {
            return [$enum->value => $enum->getLabel()];
        });
        $this->type = select('Guard Type', $options);
    }

    protected function askForPanel(): void
    {
        if ($this->type !== 'panel') {
            return;
        }

        $this->panel = select('Which Panel?', Terms::listPanels());

        if ($this->guardExists(Terms::getPanelSlug($this->panel), true)) {
            if (! $this->shouldRestart()) {
                return;
            }
        }
        $this->createGuard();
    }

    protected function askForModel(): void
    {
        if ($this->type !== 'model') {
            return;
        }

        $this->model = select('Which Model?', ModelRegistry::make()->getAll());

        if ($this->guardExists(Terms::getModelSlug($this->model), true)) {
            if (! $this->shouldRestart()) {
                return;
            }
        }
    }

    protected function createGuard(): void
    {
        $slug = match ($this->type) {
            'custom' => $this->slug,
            'panel' => Terms::getPanelSlug($this->panel),
            'model' => Terms::getModelSlug($this->getModel()),
        };

        $name = match ($this->type) {
            'custom' => $this->guardName,
            'panel' => ucfirst($this->panel).' Panel Guard',
            'model' => str($this->getModel())->classBasename()->append(' Model Guard')->toString(),
        };

        $this->guard = $this->createGuardRecord($name, $slug);

        if ($this->guard->wasRecentlyCreated) {
            $this->line('Guard created <fg=green>successfully</>!');
        }

        if ($this->ask('Do you want to create a condition?', true)) {
            $this->runCommand('make:terms-condition', [
                '--guard' => $this->guard->slug,
            ], $this->output);
        }
    }
}
