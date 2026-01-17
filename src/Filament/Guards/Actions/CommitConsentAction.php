<?php

namespace Betta\Terms\Filament\Guards\Actions;

use Betta\Terms\Contracts\ModelConditions;
use Filament\Actions\Action;

/**
 * @method ModelConditions getRecord(bool $withDefault = true)
 */
class CommitConsentAction extends Action
{
    public static function getDefaultName(): ?string
    {
        return 'commitConsent';
    }

    protected function setUp(): void
    {
        parent::setUp();

        $this->label(__('betta-terms::actions.commit_consent.label'));

        $this->successNotificationTitle(__('betta-terms::actions.commit_consent.notification.success'));

        $this->disabled(fn() => $this->hasCommittedConsent());

        $this->tooltip(fn() => $this->hasCommittedConsent() ? __('betta-terms::actions.commit_consent.notification.committed') : null);

        $this->color(fn() => $this->hasCommittedConsent() ? 'gray' : 'success');

        $this->action(function () {
            $this->getRecord()->performCommitConsent();
            $this->success();
        });
    }

    protected function hasCommittedConsent(): bool
    {
        return $this->getRecord()->hasCommittedConsent();
    }
}
