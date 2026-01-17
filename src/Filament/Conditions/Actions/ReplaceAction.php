<?php

namespace Betta\Terms\Filament\Conditions\Actions;

use Betta\Terms\Models\Condition;
use Betta\Terms\Terms;
use Filament\Actions\Action;
use Filament\Support\Icons\Heroicon;

class ReplaceAction extends Action
{
    public static function getDefaultName(): ?string
    {
        return 'replace';
    }

    protected function setUp(): void
    {
        parent::setUp();

        $this->icon(Heroicon::ArrowPath);

        $this->requiresConfirmation();

        $this->label(__('betta-terms::actions.replace.label'));

        $this->modalHeading(__('betta-terms::actions.replace.term.heading'));

        $this->visible(fn (?Condition $record) => $record && $record->onceAccepted() && ! $record->hasSuccessor());

        $this->action(function (?Condition $record) {
            if (! $record) {
                return;
            }

            $condition = $record->replace();

            $this->redirect(Terms::getConditionResource()::getUrl('edit', ['record' => $condition]));
        });
    }
}
