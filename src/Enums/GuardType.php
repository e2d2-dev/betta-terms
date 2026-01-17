<?php

namespace Betta\Terms\Enums;

use Filament\Support\Contracts\HasLabel;
use Illuminate\Contracts\Support\Htmlable;

enum GuardType: string implements HasLabel
{
    case Custom = 'custom';
    case Model = 'model';
    case Panel = 'panel';

    public function getLabel(): string|Htmlable|null
    {
        return __("betta-terms::enum.guard_type.{$this->value}.label");
    }
}
