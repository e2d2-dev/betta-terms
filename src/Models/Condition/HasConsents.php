<?php

namespace Betta\Terms\Models\Condition;

use Betta\Terms\Models\Consent;
use Betta\Terms\Terms;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @property Collection $consents
 * @property Collection $pivotConsents
 */
trait HasConsents
{
    public function accept(): void
    {
        $this->consents()->syncWithoutDetaching([auth()->id()]);
    }

    public function consents(): BelongsToMany
    {
        return $this->belongsToMany(Terms::getUserModel(), Terms::getTable('consent'))
            ->withTimestamps(updatedAt: false);
    }

    public function hasConsents(): bool
    {
        return $this->consents()->count() > 0;
    }

    public function onceAccepted(): bool
    {
        return $this->consents()->count() > 0;
    }

    public function pivotConsents(): HasMany
    {
        return $this->hasMany(Consent::class);
    }
}
