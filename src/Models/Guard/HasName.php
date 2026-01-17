<?php

namespace Betta\Terms\Models\Guard;

use Illuminate\Database\Eloquent\Casts\Attribute;

/**
 * @property ?string $name
 */
trait HasName
{
    protected function initializeHasName(): void
    {
        $this->mergeFillable([
            'name',
        ]);
    }

    public function displayName(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->isModelGuard() ? str($this->model)->classBasename()->append(' Guard') : $this->name
        );
    }
}
