<?php

namespace Betta\Terms\Contracts;

use Betta\Terms\Models\Condition;

interface ReplacesCondition
{
    public function replace(Condition $condition): Condition;
}
