<?php

namespace Betta\Terms\Filament\Forms;

use Betta\Terms\Contracts\CanConsent;
use Betta\Terms\Filament\Forms\Concerns\HasExcludes;
use Betta\Terms\Filament\Forms\Concerns\HasGuard;
use Betta\Terms\Filament\Forms\Concerns\HasOnly;
use Betta\Terms\Filament\Forms\Concerns\HasSchemas;
use Betta\Terms\Filament\Forms\Concerns\HasSignedOnSlug;
use Betta\Terms\Filament\Forms\Concerns\HasStateCollections;
use Betta\Terms\Filament\Forms\Concerns\HasValidationException;
use Betta\Terms\Filament\Forms\Consent\HasConsentRelation;
use Betta\Terms\Filament\Forms\Consent\HasGuardConditions;
use Betta\Terms\Filament\Forms\Consent\HasModelConditions;
use Betta\Terms\Models\Condition;
use Betta\Terms\Terms;
use Filament\Forms\Components\Repeater;
use Illuminate\Database\Eloquent\Model;

class ConsentPicker extends Repeater
{
    use HasConsentRelation;
    use HasExcludes;
    use HasGuard;
    use HasGuardConditions;
    use HasModelConditions;
    use HasOnly;
    use HasSchemas;
    use HasSignedOnSlug;
    use HasStateCollections;
    use HasValidationException;

    public static function getDefaultName(): ?string
    {
        return 'consents';
    }

    public function getStateLabel(): ?string
    {
        $state = $this->getState();

        return $state && count($state) > 1
            ? __('betta-terms::models.term.plural')
            : __('betta-terms::models.term.singular');
    }

    protected function setUp(): void
    {
        parent::setUp();

        $this->label(fn () => $this->getStateLabel());

        $this->visible(fn ($state) => $state && count($state) > 0);

        $this->deletable(false);

        $this->addable(false);

        $this->reorderable(false);

        $this->default(fn () => $this->fillGuardConditions());

        $this->formatStateUsing(fn () => $this->fillGuardConditions());

        $this->relationship(
            name: fn () => $this->getConsentRelationName()
        );

        $this->loadStateFromRelationshipsUsing(function () {
            return $this->state(
                $this->getGuardConditions()
                    ->map(fn (Condition $condition) => $this->getModelConsentedState($condition))
                    ->toArray()
            );
        });

        $this->saveRelationshipsUsing(function () {
            $this->throwValidationException();

            if ($this->implementsGuardConditions()) {
                $this->saveModelConditions();

                return;
            }
            $user = $this->getUser();
            $conditions = $this->getGuardConditions();

            $this->getStateCollection()->each(function ($consent) use ($user, $conditions) {
                /** @var Condition $condition */
                $condition = $conditions->first(fn (Condition $condition) => $condition->slug === $consent['slug']);
                $accepted = $consent['accepted'] ?? false;

                if (! $accepted) {
                    return;
                }
                $user->consentCondition($condition, $this->getSignedOnSlug());
            });
        });

        $this->schema(fn () => $this->isCompact()
            ? $this->getCompactConditionSchema()
            : $this->getOpenConditionSchema()
        );
    }

    protected function getUser(): CanConsent
    {
        $user = auth()->user();

        if (! $user) {
            $user = $this->extractUserFromLivewire();
        }

        return $user;
    }

    protected function extractUserFromLivewire(): ?Model
    {
        $email = $this->getLivewire()->data['email'] ?? null;
        throw_if(! $email, 'User could not be extracted from form');

        return Terms::getUserModel()::query()->where('email', $email)->first();
    }
}
