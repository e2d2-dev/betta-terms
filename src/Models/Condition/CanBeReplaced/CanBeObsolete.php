<?php

namespace Betta\Terms\Models\Condition\CanBeReplaced;

use Illuminate\Database\Eloquent\Builder;

/**
 * @property bool $is_obsolete
 */
trait CanBeObsolete
{
    protected function initializeCanBeObsolete(): void
    {
        $this->mergeCasts([
            'is_obsolete' => 'boolean',
        ]);
    }

    public function obsolete(): static
    {
        $this->is_obsolete = true;

        return $this;
    }

    public function isObsolete(): bool
    {
        return (bool) $this->is_obsolete;
    }

    public function scopeObsolete(Builder $query, bool $condition = true): void
    {
        $query->where('is_obsolete', $condition);
    }

    public function obsoletesPredecessor(): bool
    {
        return $this->hasPredecessor()
            and ! $this->predecessor->isObsolete()
            and $this->hasValidSource();
    }
}
