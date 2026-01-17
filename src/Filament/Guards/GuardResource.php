<?php

namespace Betta\Terms\Filament\Guards;

use BackedEnum;
use Betta\Terms\Filament\Guards\Pages\CreateGuard;
use Betta\Terms\Filament\Guards\Pages\EditGuard;
use Betta\Terms\Filament\Guards\Pages\ListGuards;
use Betta\Terms\Filament\Guards\RelationManagers\ConditionsRelationManager;
use Betta\Terms\Filament\Guards\Schemas\GuardForm;
use Betta\Terms\Filament\Guards\Tables\GuardsTable;
use Betta\Terms\Terms;
use Filament\Panel;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Illuminate\Contracts\Support\Htmlable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class GuardResource extends Resource
{
    protected static ?string $recordTitleAttribute = 'name';

    public static function form(Schema $schema): Schema
    {
        return GuardForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return GuardsTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            ConditionsRelationManager::make(),
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListGuards::route('/'),
            'create' => CreateGuard::route('/create'),
            'edit' => EditGuard::route('/{record}/edit'),
        ];
    }

    public static function getModel(): string
    {
        return Terms::getModel('guard');
    }

    public static function getRecordRouteBindingEloquentQuery(): Builder
    {
        return parent::getRecordRouteBindingEloquentQuery()
            ->withoutGlobalScopes([
                SoftDeletingScope::class,
            ]);
    }

    public static function getModelLabel(): string
    {
        return __('betta-terms::models.guard.singular');
    }

    public static function getPluralModelLabel(): string
    {
        return __('betta-terms::models.guard.plural');
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
        return Terms::getConfig('resources.guard.icon', Heroicon::ShieldCheck);
    }

    public static function shouldRegisterNavigation(): bool
    {
        return Terms::getConfig('resources.guard.registerNavigation');
    }
}
