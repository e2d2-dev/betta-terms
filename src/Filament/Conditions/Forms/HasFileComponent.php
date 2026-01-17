<?php

namespace Betta\Terms\Filament\Conditions\Forms;

use Betta\Terms\Enums\Source;
use Filament\Forms\Components\ToggleButtons;

class HasFileComponent extends ToggleButtons
{
    public static function getDefaultName(): ?string
    {
        return 'has_file';
    }

    protected function setUp(): void
    {
        parent::setUp();

        $this->boolean();

        $this->inlineLabel();

        $this->label(__('betta-terms::fields.as_file.label'));

        $this->visible(fn ($get) => static::canHaveFile($get('source')));

        $this->inline();

        $this->reactive();
    }

    public static function canHaveFile(?Source $source = null): bool
    {
        if (is_null($source)) {
            return false;
        }

        return in_array($source, [Source::Pdf, Source::Image, Source::Markdown]);
    }

    public static function canHaveUrl(?Source $source = null): bool
    {
        if (is_null($source)) {
            return false;
        }

        return in_array($source, [Source::Link, Source::Pdf, Source::Image]);
    }
}
