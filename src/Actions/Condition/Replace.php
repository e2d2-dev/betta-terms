<?php

namespace Betta\Terms\Actions\Condition;

use Betta\Terms\Contracts\ReplacesCondition;
use Betta\Terms\Models\Condition;
use Betta\Terms\Terms;

class Replace implements ReplacesCondition
{
    public function replace(Condition $condition): Condition
    {
        /** @var Condition $fresh */
        $fresh = Terms::getConditionModel()::create([
            'name' => $condition->name,
            'description' => $condition->description,
            'revision' => $condition->revision + 1,
        ]);

        $condition->update([
            'successor_id' => $fresh->id,
        ]);

        return $fresh;
    }
}
