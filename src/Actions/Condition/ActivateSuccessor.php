<?php

namespace Betta\Terms\Actions\Condition;

use Betta\Terms\Contracts\ActivatesSuccessor;
use Betta\Terms\Events\Condition\SuccessorActivated;
use Betta\Terms\Models\Condition;
use Betta\Terms\Models\ConditionGuard;

class ActivateSuccessor implements ActivatesSuccessor
{
    public function activate(Condition $condition): void
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
