<?php

namespace Betta\Terms\Filament\Conditions\RelationManagers;

use BackedEnum;
use Betta\Terms\Filament\Guards\Tables\Columns\DisplayNameColumn;
use Betta\Terms\Filament\Guards\Tables\Columns\IsActiveToggleColumn;
use Betta\Terms\Filament\Guards\Tables\Columns\IsSkippableToggleColumn;
use Betta\Terms\Models\Condition;
use Betta\Terms\Terms;
use Filament\Actions\AttachAction;
use Filament\Actions\CreateAction;
use Filament\Actions\DetachAction;
use Filament\Actions\EditAction;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Illuminate\Contracts\Support\Htmlable;
use Illuminate\Database\Eloquent\Model;

class GuardsRelationManager extends RelationManager
{
    protected static string $relationship = 'guards';

    public static function getRelatedResource(): ?string
    {
        return Terms::getGuardResource();
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('name')
            ->columns([
                DisplayNameColumn::make()->grow(),
                IsSkippableToggleColumn::make(),
                IsActiveToggleColumn::make(),
            ])
            ->headerActions([
                CreateAction::make(),
                AttachAction::make()
                    ->icon(Heroicon::ArrowsPointingIn)
                    ->preloadRecordSelect(),
            ])
            ->recordUrl(fn($record) => Terms::getGuardResource()::getUrl('edit',['record' => $record]))
            ->recordActions([
                DetachAction::make()->iconButton()->icon(Heroicon::ArrowsPointingOut),
            ]);
    }

    /**
     * @param  Condition  $ownerRecord
     */
    public static function getBadge(Model $ownerRecord, string $pageClass): ?string
    {
        return $ownerRecord->guards()->count();
    }

    public static function getIcon(Model $ownerRecord, string $pageClass): string|BackedEnum|Htmlable|null
    {
        return Terms::getConfig('resources.guard.icon', Heroicon::ShieldCheck);
    }
}
