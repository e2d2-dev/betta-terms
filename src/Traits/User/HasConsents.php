<?php

namespace Betta\Terms\Traits\User;

use Betta\Terms\Contracts\CreateConsent;
use Betta\Terms\Models\Condition;
use Betta\Terms\Relations\ManyOpenConsents;
use Betta\Terms\Relations\ManyOpenConsentsRelation;
use Betta\Terms\Terms;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

/**
 * @property Collection $consents
 * @property Collection $openConsents
 */
trait HasConsents
{
    use ManyOpenConsentsRelation;

    public function consents(): BelongsToMany
    {
        return $this->belongsToMany(Terms::getConditionModel(), Terms::getTable('consent'))
            ->withTimestamps(updatedAt: false);
    }

    public function openConsents(): ManyOpenConsents
    {
        return $this->manyOpenConsents(Terms::getConditionModel());
    }

    public function consentCondition(Condition $condition, ?string $signedOn = null): static
    {
        $action = app(CreateConsent::class, ['condition' => $condition]);
        $action->handle($this, $condition, $signedOn);

        return $this;
    }
}
