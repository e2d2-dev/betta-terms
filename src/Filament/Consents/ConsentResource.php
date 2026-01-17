<?php

namespace Betta\Terms\Filament\Consents;

use BackedEnum;
use Betta\Terms\Filament\Consents\Pages\ListConsents;
use Betta\Terms\Filament\Consents\Tables\ConsentsTable;
use Betta\Terms\Terms;
use Filament\Panel;
use Filament\Resources\Resource;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Illuminate\Contracts\Support\Htmlable;

class ConsentResource extends Resource
{
    public static function getModel(): string
    {
        return Terms::getConsentModel();
    }

    protected static ?string $recordTitleAttribute = 'name';

    public static function table(Table $table): Table
    {
        return ConsentsTable::configure($table);
    }

    public static function getPages(): array
    {
        return [
            'index' => ListConsents::route('/'),
        ];
    }

    public static function getModelLabel(): string
    {
        return __('betta-terms::models.consent.singular');
    }

    public static function getPluralModelLabel(): string
    {
        return __('betta-terms::models.consent.plural');
    }

    public static function getNavigationGroup(): string
    {
        return __(Terms::getResourceNavigationGroup());
    }

    public static function getSlug(?Panel $panel = null): string
    {
        return Terms::getConfig('resources.slug-prefix').'/'.parent::getSlug($panel);
    }

    public static function getNavigationIcon(): string|BackedEnum|Htmlable|null
    {
        return Terms::getConfig('resources.consent.icon', Heroicon::CheckBadge);
    }

    public static function shouldRegisterNavigation(): bool
    {
        return Terms::getConfig('resources.consent.registerNavigation');
    }
}
