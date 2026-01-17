<?php

namespace Betta\Terms\Filament\Forms\Fields;

use Betta\Terms\Filament\Forms\Concerns\CanHaveConditionFromState;
use Betta\Terms\Models\Condition;
use Filament\Forms\Components\ViewField;

/**
 * @method Condition getRecord(bool $withDefault = true)
 */
class EmbedField extends ViewField
{
    use CanHaveConditionFromState;

    public static function getDefaultName(): ?string
    {
        return 'embed';
    }

    protected function setUp(): void
    {
        parent::setUp();

        $this->hiddenLabel();

        $this->visible(fn () => $this->getRecord()->hasEmbedUrl());

        $this->dehydrated(false);

        $this->view('betta-terms::embed', fn () => [
            'url' => $this->getRecord()->getEmbedUrl(),
            'name' => $this->getRecord()->name,
            'source' => $this->getRecord()->source,
        ]);
    }
}
