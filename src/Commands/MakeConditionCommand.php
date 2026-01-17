<?php

namespace Betta\Terms\Commands;

use Betta\Terms\Commands\Concerns\CanAskToRestart;
use Betta\Terms\Commands\Concerns\ConditionStuff;
use Betta\Terms\Enums\Source;
use Betta\Terms\Models\Condition;
use Betta\Terms\Models\Guard;
use Betta\Terms\Terms;
use Filament\Resources\Resource;
use Filament\Support\Commands\Concerns\CanOpenUrlInBrowser;
use Illuminate\Console\Command;

use function Laravel\Prompts\select;

class MakeConditionCommand extends Command
{
    use CanAskToRestart;
    use CanOpenUrlInBrowser;
    use ConditionStuff;

    protected $description = 'Create a betta-terms condition';

    protected $name = 'make:terms-condition';

    protected $signature = 'make:terms-condition {name?} {--guard=}';

    protected string $source;

    protected string $conditionName;

    protected ?Guard $guard = null;

    protected ?string $conditionDescription;

    protected ?Condition $condition = null;

    public function handle(): int
    {
        $this->line('<fg=magenta>[</> Betta Terms make-condition <fg=magenta>]</>');

        $this->askToCreateGuard();

        $this->askForName();

        $this->askForDescription();

        $this->askForType();

        $this->createCondition();

        $this->attachGuard();

        $this->resourceInfo();

        return static::SUCCESS;
    }

    protected function createCondition(): void
    {
        $this->condition = $this->createConditionRecord($this->conditionName, $this->conditionDescription, $this->source);
    }

    protected function resourceInfo(): void
    {
        $this->line('You <fg=red>still need to</> add content to the condition. This is <fg=green>available</> through the management resources');

        if (! $this->getConditionResourceUrl()) {
            $this->error('The ConditionResource is <fg=red>>not</> registered!');
            $this->newLine();
            $this->line('Add the <fg=green>ManageTermsPlugin</> to your panel...');

            return;
        }

        $url = $this->getConditionResourceUrl();
        $this->line("url: {$url}");

        if ($this->ask('Should we open the resource now?', true)) {
            $this->openUrlInBrowser($url);
        }
    }

    protected function getConditionResourceUrl(): ?string
    {
        /** @var ?resource $class */
        $class = filament()->getModelResource(Terms::getConditionModel());

        if (! $class) {
            return null;
        }

        return $class::getUrl('edit', ['record' => $this->condition]);
    }

    protected function attachGuard(): void
    {
        if ($this->guard !== null) {
            $this->condition->guards()->attach([$this->guard->getKey()]);

            $name = $this->guard->name;
            $this->line("Guard <fg=magenta>*</>{$name}<fg=magenta>*</> <fg=green>attached</>!");
        }
    }

    protected function askForName(): void
    {
        $this->conditionName = $this->ask('What should be the name of the condition?');
    }

    protected function askForDescription(): void
    {
        $this->conditionDescription = $this->ask('What should be the description of the condition?');
    }

    protected function askForType(): void
    {
        $options = collect(Source::cases())->mapWithKeys(function ($enum) {
            return [$enum->value => $enum->getLabel()];
        });
        $this->source = select('Whats should be the source?', $options);
    }

    protected function askToCreateGuard(): void
    {
        $slug = $this->option('guard');

        $guard = $slug ? $this->getGuard($slug) : null;

        if ($slug and ! $guard) {
            $this->info("... Guard does not exist: {$guard->name} ...");
        }
        if (! $guard) {
            $guard = select('For which Guard?', ['none' => 'None yet', ...Terms::getGuardList()]);
        }
        if ($guard === 'none') {
            return;
        }

        $this->guard = $this->getGuard($guard);
        $this->line("<fg=magenta>[</> Selected guard <fg=green>{$this->guard->name}</>: <fg=magenta>]</>");
    }

    protected function getGuard(?string $slug = null): ?Guard
    {
        $slug = $slug ?? $this->option('guard');

        return Terms::getGuardModel()::bySlug($slug);
    }
}
