<?php

namespace Betta\Terms\Contracts;

use Betta\Terms\Models\Condition;

interface ActivatesSuccessor
{
    public function activate(Condition $condition): void;
}
