<?php

namespace Betta\Terms\Filament\Conditions\Actions;

use Betta\Terms\Filament\Conditions\ConditionResource;
use Betta\Terms\Models\Condition;
use Betta\Terms\Terms;
use Filament\Actions\Action;
use Filament\Support\Icons\Heroicon;

class SuccessorAction extends Action
{
    public static function getDefaultName(): ?string
    {
        return 'successor';
    }

    protected function setUp(): void
    {
        parent::setUp();

        $this->icon(Heroicon::ArrowRight);

        $this->requiresConfirmation();

        $this->label(__('betta-terms::entities.successor.singular'));

        $this->visible(fn (?Condition $record) => $record && $record->hasSuccessor());

        $this->url(fn (?Condition $record) => $record
            ? Terms::getConditionResource()::getUrl('edit', ['record' => $record->successor])
            : null
        );

    }
}
