<?php

namespace Betta\Terms\Filament\Conditions\Forms;

use Betta\Terms\Enums\Source;
use Filament\Forms\Components\FileUpload;

class FileComponent extends FileUpload
{
    public static function getDefaultName(): ?string
    {
        return 'file';
    }

    protected function setUp(): void
    {
        parent::setUp();

        $this->hiddenLabel();

        $this->disk(config('betta-terms.fields.file.disk'));

        $this->directory(config('betta-terms.fields.file.directory'));

        $this->visibility(config('betta-terms.fields.file.visibility'));

        $this->acceptedFileTypes(fn ($get) => match ($get('source')) {
            Source::Pdf => ['application/pdf'],
            Source::Image => ['image/*'],
            // TODO does not pass validation
            Source::Markdown => ['text/markdown'],
            default => null,
        });

        $this->required();

        $this->visible(fn ($get) => HasFileComponent::canHaveFile($get('source')) && $get('has_file'));

        $this->validationMessages(
            __('betta-terms::fields.file.validation'),
        );
    }
}
