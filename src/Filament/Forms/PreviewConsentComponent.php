<?php

namespace Betta\Terms\Filament\Forms;

use Betta\Terms\Filament\Forms\Concerns\HasSchemas;
use Filament\Forms\Components\Repeater;

class PreviewConsentComponent extends Repeater
{
    use HasSchemas;

    public static function getDefaultName(): ?string
    {
        return 'consents';
    }

    protected function setUp(): void
    {
        parent::setUp();

        $this->label(fn ($state) => $state && count($state) > 1
            ? __('betta-terms::models.term.plural')
            : __('betta-terms::models.term.singular')
        );

        $this->deletable(false);

        $this->addable(false);

        $this->reorderable(false);

        $this->default(fn () => $this->getConditions());

        $this->schema(fn () => $this->isCompact()
            ? $this->getCompactConditionSchema()
            : $this->getOpenConditionSchema()
        );
    }

    protected function getConditions(): array
    {
        return $this->getRecord()->conditions()->distinct()->get()->toArray();
    }
}
