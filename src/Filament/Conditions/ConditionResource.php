<?php

namespace Betta\Terms\Filament\Conditions;

use BackedEnum;
use Betta\Terms\Filament\Conditions\Pages\CreateCondition;
use Betta\Terms\Filament\Conditions\Pages\EditCondition;
use Betta\Terms\Filament\Conditions\Pages\ListConditions;
use Betta\Terms\Filament\Conditions\RelationManagers\ConsentsRelationManager;
use Betta\Terms\Filament\Conditions\RelationManagers\GuardsRelationManager;
use Betta\Terms\Filament\Conditions\Tables\ConditionsTable;
use Betta\Terms\Terms;
use Filament\Panel;
use Filament\Resources\Resource;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Illuminate\Contracts\Support\Htmlable;

class ConditionResource extends Resource
{
    public static function getModel(): string
    {
        return Terms::getModel('condition');
    }

    public static function table(Table $table): Table
    {
        return ConditionsTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            'guards' => GuardsRelationManager::make(),
            'consents' => ConsentsRelationManager::make(),
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListConditions::route('/'),
            'create' => CreateCondition::route('/create'),
            'edit' => EditCondition::route('/{record}/edit'),
        ];
    }

    public static function getModelLabel(): string
    {
        return __('betta-terms::models.condition.singular');
    }

    public static function getPluralModelLabel(): string
    {
        return __('betta-terms::models.condition.plural');
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
        return Terms::getConfig('resources.condition.icon', Heroicon::Newspaper);
    }

    public static function shouldRegisterNavigation(): bool
    {
        return Terms::getConfig('resources.condition.registerNavigation');
    }
}
