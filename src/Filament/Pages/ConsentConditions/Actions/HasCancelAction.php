<?php

namespace Betta\Terms\Filament\Pages\ConsentConditions\Actions;

use Filament\Actions\Action;

trait HasCancelAction
{
    public function getCancelActionLabel(): string|\Closure
    {
        return __('betta-terms::actions.cancel.label');
    }

    public function shouldHaveCancelAction(): bool
    {
        return method_exists($this, $this->getCancelLivewireActionName()) && true;
    }

    public function getCancelLivewireActionName(): string
    {
        return 'cancel';
    }

    public function getCancelAction(): Action
    {
        return Action::make('cancel')
            ->visible(fn () => $this->shouldHaveCancelAction())
            ->color('neutral')
            ->outlined()
            ->label($this->getCancelActionLabel())
            ->action($this->getCancelLivewireActionName());
    }
}
