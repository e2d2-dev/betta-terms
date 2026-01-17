<?php

namespace Betta\Terms\Filament\Conditions\Forms;

use Betta\Terms\Enums\Source;
use Closure;
use Filament\Forms\Components\TextInput;
use Filament\Notifications\Notification;
use Illuminate\Support\Facades\Http;

class UrlComponent extends TextInput
{
    public static function getDefaultName(): ?string
    {
        return 'url';
    }

    protected function setUp(): void
    {
        parent::setUp();

        $this->inlineLabel();

        $this->default('https://');

        $this->formatStateUsing(fn ($state) => $state ?: 'https://');

        $this->validationMessages(
            __('betta-terms::fields.source.url.validation'),
        );

        $this->visible(fn () => $this->getVisibility());

        $this->required();

        $this->rules([
            fn (): Closure => function (string $attribute, $value, Closure $fail) {

                try {
                    $status = Http::get($value)->status();

                    if ($status !== 200) {
                        $fail(__('betta-terms::fields.source.url.validation.check', ['code' => $status]));
                    }
                } catch (\Exception $exception) {
                    Notification::make()
                        ->danger()
                        ->body($exception->getMessage())
                        ->send();
                }
            },
        ]);
    }

    public function getVisibility(): bool
    {
        $get = $this->makeGetUtility();
        $source = $get('source');

        if (in_array($source, [Source::Link, Source::Iframe])) {
            return true;
        }

        return HasFileComponent::canHaveUrl($get('source')) && ! $get('has_file');
    }
}
