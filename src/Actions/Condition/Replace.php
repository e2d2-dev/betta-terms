<?php

namespace Betta\Terms\Actions\Condition;

use Betta\Terms\Models\Condition;
use Betta\Terms\Terms;
use Lorisleiva\Actions\Concerns\AsAction;

class Replace
{
    use AsAction;

    public function handle(Condition $condition): Condition
    {
        /** @var Condition $fresh */
        $fresh = Terms::getModel('condition')::create([
            'name' => $condition->name,
            'description' => $condition->description,
        ]);

        $condition->update([
            'successor_id' => $fresh->id,
        ]);

        return $fresh;
    }
}
