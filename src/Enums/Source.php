<?php

declare(strict_types=1);

namespace Betta\Terms\Enums;

use BackedEnum;
use Filament\Support\Contracts\HasIcon;
use Filament\Support\Contracts\HasLabel;
use Filament\Support\Icons\Heroicon;
use Illuminate\Contracts\Support\Htmlable;

enum Source: string implements HasIcon, HasLabel
{
    case Pdf = 'pdf';
    case Link = 'link';
    case Text = 'text';
    case Markdown = 'markdown';
    case Iframe = 'iframe';
    case Simple = 'simple';
    case Image = 'image';

    public function getLabel(): ?string
    {
        return __("betta-terms::enum.source.{$this->value}.label");
    }

    public function getIcon(): string|BackedEnum|Htmlable|null
    {
        return match ($this) {
            self::Pdf => Heroicon::OutlinedFolder,
            self::Link => Heroicon::GlobeAlt,
            self::Text => Heroicon::PencilSquare,
            self::Iframe => null,
            self::Simple => null,
            default => Heroicon::ExclamationTriangle,
        };
    }
}
