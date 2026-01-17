<?php

namespace Betta\Terms\Models\Guard;

use Betta\Terms\Terms;

/**
 * @property ?class-string $model
 */
trait HasModel
{
    protected function initializeHasModel(): void
    {
        $this->mergeFillable([
            'model',
        ]);
    }

    public static function byModel(string $model): ?static
    {
        return static::query()->with('activeConditions')->where('slug', Terms::getModelSlug($model))->first();
    }

    public function isModelGuard(): bool
    {
        return (bool) $this->model;
    }
}
