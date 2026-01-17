<?php

namespace Betta\Terms\Commands\Concerns;

use Betta\Terms\Enums\Source;
use Betta\Terms\Models\Condition;
use Betta\Terms\Terms;

trait ConditionStuff
{
    protected function createConditionRecord(string $name, ?string $description, string $source, bool $verbose = true): Condition
    {
        $record = Terms::getModel('condition')::create([
            'name' => $name,
            'description' => $description,
            'source' => Source::tryFrom($source),
        ]);

        $this->line('Condition <fg=green>created</>!');

        return $record;
    }
}
