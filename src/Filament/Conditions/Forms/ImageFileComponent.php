<?php

namespace Betta\Terms\Filament\Conditions\Forms;

use Betta\Terms\Enums\Source;
use Betta\Terms\Filament\Forms\Source\HasTermSource;
use Filament\Forms\Components\FileUpload;

class ImageFileComponent extends FileUpload
{
    use HasTermSource;

    public static function getDefaultName(): ?string
    {
        return 'image';
    }

    protected function setUp(): void
    {
        parent::setUp();

        $this->hiddenLabel();

        $this->disk(config('betta-terms.fields.file.disk'));

        $this->directory(config('betta-terms.fields.file.directory'));

        $this->visibility(config('betta-terms.fields.file.visibility'));

        $this->source(Source::Image);

        // $this->image();

        $this->validationMessages(
            __('betta-terms::fields.file.validation'),
        );
    }
}
