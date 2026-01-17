<?php

namespace Betta\Terms\Traits\Model;

use Betta\Terms\Actions\Model\CommitConsent;
use Betta\Terms\Contracts\ModelConditions;
use Betta\Terms\Models\Guard;
use Betta\Terms\Relations\HasModelGuard;
use Betta\Terms\Relations\ManyModelConditions;
use Betta\Terms\Relations\ModelConditionsRelation;
use Betta\Terms\Relations\ModelGuardRelation;
use Illuminate\Database\Eloquent\Collection;

/**
 * @property Collection $guardConditions
 * @property ?Guard $consentGuard
 */
trait HasGuardConditions
{
    use ModelConditionsRelation;
    use ModelGuardRelation;

    public function guardConditionsAttribute(): string
    {
        return 'conditions';
    }

    protected function initializeHasGuardConditions(): void
    {
        $this->mergeCasts([
            $this->guardConditionsAttribute() => 'array',
        ]);

        $this->mergeFillable([
            $this->guardConditionsAttribute(),
        ]);
    }

    protected static function bootHasGuardConditions(): void
    {
        static::created(function (ModelConditions $model) {
            $model->commitConsent();
        });

        static::updated(function (ModelConditions $model) {
            $model->commitConsent();
        });
    }

    public function consentGuard(): HasModelGuard
    {
        return $this->hasModelGuard();
    }

    public function guardConditions(): ManyModelConditions
    {
        return $this->manyModelConditions();
    }

    public function getSavedGuardConditions(?string $key = null): array
    {
        $data = $this->{$this->guardConditionsAttribute()} ?? [];

        return $key ? $data[$key] ?? [] : $data;
    }

    public function commitConsent(): void
    {
        if (! empty($this->getSavedGuardConditions('consent')) and $this->commitConsentWhen()) {
            $action = app(CommitConsent::class);
            $action->handle($this);
        }
    }

    public function hasCommittedConsent(): bool
    {
        return collect($this->getAttribute($this->guardConditionsAttribute()))->has('committed');
    }

    public function getIsConsentCommittedAttribute(): bool
    {
        return $this->hasCommittedConsent();
    }

    public function commitConsentWhen(): bool
    {
        return true;
    }
}
