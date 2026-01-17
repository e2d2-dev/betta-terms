<?php

namespace Betta\Terms\Filament\Conditions\Forms;

use Betta\Terms\Enums\Source;
use Betta\Terms\Filament\Forms\Source\HasTermSource;
use Filament\Forms\Components\RichEditor;

class TextComponent extends RichEditor
{
    use HasTermSource;

    public static function getDefaultName(): ?string
    {
        return 'text';
    }

    protected function setUp(): void
    {
        parent::setUp();

        $this->source(Source::Text);

        $this->columnSpanFull();

        $this->hiddenLabel();

        $this->validationMessages(
            __('betta-terms::fields.text.validation'),
        );
    }
}
