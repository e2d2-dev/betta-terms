<?php

namespace Betta\Terms\Traits;

trait FromArray
{
    public static function fromArray(array $state): static
    {
        return new static($state);
    }
}
