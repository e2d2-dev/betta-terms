<?php

namespace Betta\Terms\Filament\Conditions\Pages;

use Betta\Terms\Filament\Conditions\Actions\DeleteAction;
use Betta\Terms\Filament\Conditions\Actions\PredecessorAction;
use Betta\Terms\Filament\Conditions\Actions\ReplaceAction;
use Betta\Terms\Filament\Conditions\Actions\SuccessorAction;
use Betta\Terms\Filament\Conditions\RelationManagers\ConsentsRelationManager;
use Betta\Terms\Filament\Conditions\RelationManagers\GuardsRelationManager;
use Betta\Terms\Filament\Conditions\Schemas\ConditionEditForm;
use Betta\Terms\Models\Condition;
use Betta\Terms\Terms;
use Filament\Actions\Action;
use Filament\Resources\Pages\EditRecord;
use Filament\Schemas\Schema;

/**
 * @property Condition $record
 */
class EditCondition extends EditRecord
{
    public static function getResource(): string
    {
        return Terms::getConditionResource();
    }

    protected function getHeaderActions(): array
    {
        return [
            PredecessorAction::make(),
            SuccessorAction::make(),
            ReplaceAction::make(),
            DeleteAction::make(),
        ];
    }

    public function form(Schema $schema): Schema
    {
        return ConditionEditForm::configure($schema);
    }

    protected function getSaveFormAction(): Action
    {
        return parent::getSaveFormAction()
            ->submit(false)
            ->requiresConfirmation(fn () => $this->obsoletesPredecessor())
            ->modalHeading(fn () => $this->getSaveActionHeading())
            ->modalDescription(fn () => $this->getSaveActionDescription())
            ->action(fn () => $this->save());

    }

    public function save(bool $shouldRedirect = true, bool $shouldSendSavedNotification = true): void
    {

        if ($this->obsoletesPredecessor()) {
            $this->record->activateSuccessor();
        }
        parent::save($shouldRedirect, $shouldSendSavedNotification);
        $this->redirect(static::getUrl(['record' => $this->record]));
    }

    public function getRelationManagers(): array
    {
        $managers = [
            'guards' => GuardsRelationManager::make(),
            'consents' => ConsentsRelationManager::make(),
        ];

        if ($this->getRecord()->isObsolete()) {
            unset($managers['guards']);
        }

        return $managers;
    }

    public function getSaveActionHeading(): ?string
    {
        return $this->obsoletesPredecessor() ? __('betta-terms::actions.replace.will.heading') : null;
    }

    public function getSaveActionDescription(): ?string
    {
        return $this->obsoletesPredecessor() ? __('betta-terms::actions.mark_obsolete.predecessor.will.heading') : null;
    }

    public function obsoletesPredecessor(): bool
    {
        return $this->record->obsoletesPredecessor();
    }
}
