<?php

namespace Betta\Terms\Models\Condition;

trait CanBeSkipped
{
    public function isSkippable(): bool
    {
        return $this->guardConfig->isSkippable();
    }

    public function isRequired(): bool
    {
        return ! $this->guardConfig->isSkippable();
    }
}
