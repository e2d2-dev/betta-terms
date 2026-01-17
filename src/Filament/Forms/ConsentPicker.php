<?php

namespace Betta\Terms\Filament\Forms;

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
use Betta\Terms\Terms;
use Filament\Forms\Components\Repeater;
use Illuminate\Database\Eloquent\Builder;
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

        $this->default(fn () => $this->getGuardConditions());

        $this->formatStateUsing(fn () => $this->getGuardConditions());

        $this->relationship(
            name: fn () => $this->getConsentRelationName()
        );

        $this->loadStateFromRelationshipsUsing(function () {
            return $this->state(
                array_map(fn ($condition) => array_merge($condition, $this->getConsentedState($condition)), $this->getGuardConditions()));
        });

        $this->saveRelationshipsUsing(function () {
            $this->throwValidationException();

            if ($this->implementsGuardConditions()) {
                $this->saveModelConditions();

                return;
            }
            $user = $this->getUser();

            $this->getStateCollection()->each(function ($condition) use ($user) {
                if ($condition->isAccepted()) {
                    $user->consentBySlug($condition->slug, $this->getSignedOnSlug());
                }
            });
        });

        $this->schema(fn () => $this->isCompact()
            ? $this->getCompactConditionSchema()
            : $this->getOpenConditionSchema()
        );
    }

    protected function getUser(): Model
    {
        $user = auth()->user();

        if (! $user) {
            $email = $this->getLivewire()->data['email'] ?? null;
            throw_if(! $email, 'User could not be extracted from form');
            $user = Terms::getModel('user')::where('email', $email)->first();
        }

        return $user;
    }
}
