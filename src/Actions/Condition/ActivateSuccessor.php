<?php

namespace Betta\Terms\Actions\Condition;

use Betta\Terms\Events\Condition\SuccessorActivated;
use Betta\Terms\Models\Condition;
use Betta\Terms\Models\ConditionGuard;
use Lorisleiva\Actions\Concerns\AsAction;

class ActivateSuccessor
{
    use AsAction;

    public function handle(Condition $condition): void
    {
        if (! $condition->isSuccessor()) {
            return;
        }

        $condition->predecessor->obsolete()->save();

        ConditionGuard::query()
            ->where('condition_id', $condition->predecessor->getKey())
            ->update(['condition_id' => $condition->getKey()]);

        SuccessorActivated::dispatch($condition);
    }
}
