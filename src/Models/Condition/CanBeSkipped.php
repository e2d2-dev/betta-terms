<?php

namespace Betta\Terms\Models\Condition;

trait CanBeSkipped
{
    public function isSkippable(): bool
    {
        $value = $this->pivot['is_skippable'] ?? false;

        return (bool) $value;
    }
}
