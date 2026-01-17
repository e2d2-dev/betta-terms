<?php

namespace Betta\Terms\Models\Condition\CanBeReplaced;

use Betta\Terms\Models\Condition;

/**
 * @property int $revision
 */
trait HasRevision
{
    protected function initializeHasRevision(): void
    {
        $this->mergeFillable([
            'revision',
        ]);

        $this->mergeCasts([
            'revision' => 'int',
        ]);
    }

    protected static function bootHasRevision(): void
    {
        static::creating(function (Condition $term) {
            $term->setRevision();
        });
    }

    private function setRevision(): void
    {
        $this->revision = $this->getRevisionNumber();
    }

    public function getRevision(): int
    {
        return $this->revision;
    }

    public function getRevisionNumber(): int
    {
        return $this->hasPredecessor()
            ? $this->getFreshRevisionNumber()
            : 2;
    }

    public function getFreshRevisionNumber(): int
    {
        return $this->revision = $this->predecessor->revision + 1;
    }

    public function hasRevision(): bool
    {
        return filled($this->revision);
    }
}
