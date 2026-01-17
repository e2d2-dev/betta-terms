<?php

namespace Betta\Terms\Traits\User;

use Betta\Terms\Actions\ConsentBySlug;
use Betta\Terms\Relations\ManyOpenConsents;
use Betta\Terms\Relations\ManyOpenConsentsRelation;
use Betta\Terms\Terms;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @property Collection $consents
 */
trait HasConsents
{
    use ManyOpenConsentsRelation;

    public function consents(): BelongsToMany
    {
        return $this->belongsToMany(Terms::getModel('condition'), Terms::getTable('consent'))
            ->withTimestamps(updatedAt: false);
    }

    public function openConsents(): ManyOpenConsents
    {
        return $this->manyOpenConsents(Terms::getModel('condition'));
    }

    public function consentBySlug(string $slug, ?string $signedOn = null): static
    {
        ConsentBySlug::run($this, $slug, $signedOn);

        return $this;
    }
}
