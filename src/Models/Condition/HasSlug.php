<?php

namespace Betta\Terms\Models\Condition;

use Betta\Terms\Models\Condition;
use Illuminate\Support\Str;

/**
 * @property string $slug
 */
trait HasSlug
{
    protected static function bootHasSlug(): void
    {
        static::creating(function (Condition $term) {
            $term->setSlug();
        });
    }

    public function setSlug(): void
    {
        if ($this->slug) {
            return;
        }

        $this->slug = $this->getSlug();
    }

    public function getSlug(): string
    {
        return ! $this->hasPredecessor()
            ? Str::slug($this->getTimeStampPrefix().$this->name)
            : $this->getSlugWithRevision();
    }

    protected function getTimeStampPrefix(): string
    {
        return now()->timestamp.'_';
    }

    public function getSlugWithRevision(): string
    {
        return $this->getPredecessorSlug().$this->getRevisionSuffix();
    }

    private function getRevisionSuffix(): string
    {
        return '-r'.$this->getRevision();
    }

    private function getPredecessorSlug(): string
    {
        return str($this->predecessor->slug)
            ->after('_')
            ->prepend($this->getTimeStampPrefix())
            ->beforeLast('-r')
            ->toString();
    }

    public static function bySlug(string $slug): Condition
    {
        return static::query()->where('slug', $slug)->first();
    }
}
