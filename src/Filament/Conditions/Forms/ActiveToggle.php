<?php

namespace Betta\Terms\Filament\Conditions\Forms;

use Betta\Terms\Models\Condition;
use Filament\Forms\Components\Toggle;
use Filament\Notifications\Notification;
use Filament\Schemas\Components\Utilities\Set;

class ActiveToggle extends Toggle
{
    public static function getDefaultName(): ?string
    {
        return 'is_active';
    }

    protected function setUp(): void
    {
        parent::setUp();

        $this->visibleOn('edit');

        $this->label(__('betta-terms::fields.is_active.label'));

        $this->reactive();

        $this->onColor('success');

        $this->default(false);

        $this->disabled(function (?Condition $record) {
            return $record && $record->isObsolete();
        });

        $this->afterStateUpdated(function (Condition $record, Set $set) {
            if (! $record->hasSource()) {
                $this->getWarningNotification(
                    __('betta-terms::notifications.source.no_source.title'),
                    __('betta-terms::notifications.source.option_reset'),
                )->send();

                return;
            }

            if (! $record->hasValidSource()) {
                $this->getWarningNotification(
                    __('betta-terms::notifications.source.no_data.title'),
                    __('betta-terms::notifications.source.option_reset'),
                )->send();

                return;
            }

            if ($record->hasSuccessor()) {
                $this->getWarningNotification(
                    __('betta-terms::notifications.successor.not_active.title'),
                    __('betta-terms::notifications.source.option_reset'),
                )->send();
            }
        });
    }

    protected function getWarningNotification(string $title, ?string $body = null): Notification
    {
        return Notification::make()
            ->title($title)
            ->body($body)
            ->warning();
    }
}
