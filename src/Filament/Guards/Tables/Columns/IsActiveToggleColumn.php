<?php

namespace Betta\Terms\Filament\Guards\Tables\Columns;

use Betta\Terms\Filament\Guards\Tables\Columns\Concerns\HasPredecessor;
use Filament\Notifications\Notification;
use Filament\Tables\Columns\ToggleColumn;

class IsActiveToggleColumn extends ToggleColumn
{
    use HasPredecessor;

    public static function getDefaultName(): ?string
    {
        return 'is_active';
    }

    protected function setUp(): void
    {
        parent::setUp();

        $this->label(__('betta-terms::fields.is_active.label'));

        $this->alignEnd();

        $this->onColor('success');

        $this->disabled(fn () => $this->hasActivePredecessor());

        $this->tooltip(fn () => $this->hasActivePredecessor() ? __('betta-terms::info.mark_active.active_predecessor') : null);

        $this->afterStateUpdated(function ($record, $state) {
            if ($state and ! $this->getConditionRecord()->hasValidSource()) {
                Notification::make()
                    ->warning()
                    ->title(__('betta-terms::notifications.source.no_data.title'))
                    ->send();
                parent::updateState(false);
            }
        });

        $this->disabled(fn () => ! $this->getConditionRecord()->hasValidSource());

        $this->tooltip(fn () => ! $this->getConditionRecord()->hasValidSource() ? __('betta-terms::notifications.source.no_data.title') : null);
    }
}
