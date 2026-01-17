<?php

namespace Betta\Terms\Models\Condition;

use Illuminate\Database\Eloquent\Builder;

trait CanBeUsable
{
    protected function initializeCanBeUsable(): void
    {
        $this->mergeCasts([
            'is_usable' => 'boolean',
        ]);

        $this->mergeFillable([
            'is_usable',
        ]);
    }

    protected static function bootCanBeUsable(): void
    {
        static::updating(function ($record) {
            $record->is_usable = $record->isUsable();
        });
    }

    public function isUsable(): bool
    {
        return ! $this->isObsolete() && $this->hasFileOrUrlFilled();
    }

    public function scopeUsable(Builder $query, bool $condition = true): void
    {
        $query->where('is_usable', $condition);
    }
}
