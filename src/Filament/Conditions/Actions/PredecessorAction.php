<?php

namespace Betta\Terms\Filament\Conditions\Actions;

use Betta\Terms\Filament\Conditions\ConditionResource;
use Betta\Terms\Models\Condition;
use Betta\Terms\Terms;
use Filament\Actions\Action;
use Filament\Support\Icons\Heroicon;

class PredecessorAction extends Action
{
    public static function getDefaultName(): ?string
    {
        return 'predecessor';
    }

    protected function setUp(): void
    {
        parent::setUp();

        $this->icon(Heroicon::ArrowRight);

        $this->requiresConfirmation();

        $this->label(__('betta-terms::entities.predecessor.singular'));

        $this->visible(fn (?Condition $record) => $record && $record->hasPredecessor());

        $this->url(fn (?Condition $record) => $record ? Terms::getConditionResource()::getUrl('edit', ['record' => $record->predecessor]) : null);
    }
}
