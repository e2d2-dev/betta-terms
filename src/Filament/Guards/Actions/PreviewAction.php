<?php

namespace Betta\Terms\Filament\Guards\Actions;

use Betta\Terms\Filament\Forms\PreviewConsentComponent;
use Betta\Terms\Models\Guard;
use Filament\Actions\Action;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\EmptyState;
use Filament\Schemas\Components\Group;
use Filament\Support\Icons\Heroicon;

/**
 * @method Guard getRecord(bool $withDefault = true)
 */
class PreviewAction extends Action
{
    public static function getDefaultName(): ?string
    {
        return 'preview';
    }

    protected function setUp(): void
    {
        parent::setUp();

        $this->outlined();

        $this->color('success');

        $this->label(__('betta-terms::actions.preview.label'));

        $this->modalHeading(__('betta-terms::actions.preview.label'));

        $this->modalDescription(fn () => $this->getRecord()->name);

        $this->icon(Heroicon::MagnifyingGlass);

        $this->modalIcon(Heroicon::MagnifyingGlass);

        $this->modalSubmitAction(false);

        $this->modalCancelActionLabel(__('betta-terms::actions.close.label'));

        $this->schema([
            EmptyState::make(__('betta-terms::models.condition.not_attached'))
                ->iconColor('warning')
                ->icon(Heroicon::ExclamationTriangle)
                ->visible(fn ($record) => $record->activeConditions()->count() === 0 and $record->conditions()->count() === 0),

            EmptyState::make(__('betta-terms::models.condition.none_active'))
                ->iconColor('warning')
                ->icon(Heroicon::ExclamationTriangle)
                ->visible(fn ($record) => $record->activeConditions()->count() === 0 and $record->conditions()->count() > 0),

            Group::make([
                Toggle::make('compact')
                    ->onColor('success')
                    ->offColor('danger')
                    ->label(__('betta-terms::fields.compact.label'))
                    ->reactive(),
                PreviewConsentComponent::make()
                    ->compact(fn ($get) => $get('compact')),
            ])->visible(fn ($record) => $record->activeConditions()->count()),
        ]);
    }
}
