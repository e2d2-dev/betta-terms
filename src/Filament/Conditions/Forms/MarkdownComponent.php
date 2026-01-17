<?php

namespace Betta\Terms\Filament\Conditions\Forms;

use Betta\Terms\Enums\Source;
use Betta\Terms\Filament\Forms\Source\HasTermSource;
use Filament\Forms\Components\MarkdownEditor;

class MarkdownComponent extends MarkdownEditor
{
    use HasTermSource;

    public static function getDefaultName(): ?string
    {
        return 'data';
    }

    protected function setUp(): void
    {
        parent::setUp();

        $this->source(Source::Markdown);

        $this->columnSpanFull();

        $this->hiddenLabel();

        $this->visible(fn ($get) => $get('source') === Source::Markdown and ! $get('has_file'));

        $this->validationMessages(
            __('betta-terms::fields.text.validation'),
        );
    }
}
