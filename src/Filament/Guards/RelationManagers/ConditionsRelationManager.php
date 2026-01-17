<?php

namespace Betta\Terms\Filament\Guards\RelationManagers;

use Betta\Terms\Filament\Conditions\Tables\Columns\RevisionColumn;
use Betta\Terms\Filament\Guards\Tables\Columns\IsActiveToggleColumn;
use Betta\Terms\Filament\Guards\Tables\Columns\IsPersistentToggleColumn;
use Betta\Terms\Filament\Guards\Tables\Columns\IsSkippableToggleColumn;
use Betta\Terms\Filament\Tables\Columns\NameColumn;
use Betta\Terms\Filament\Tables\Columns\SourceColumn;
use Betta\Terms\Terms;
use Filament\Actions\AttachAction;
use Filament\Actions\CreateAction;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class ConditionsRelationManager extends RelationManager
{
    public static function getRelatedResource(): ?string
    {
        return Terms::getConditionResource();
    }

    protected static string $relationship = 'conditions';

    public function table(Table $table): Table
    {
        return $table
            ->reorderable('order')
            ->recordTitleAttribute('name')
            ->columns([
                NameColumn::make()
                    ->grow()
                    ->searchable(),

                SourceColumn::make(),
                RevisionColumn::make()
                    ->visibleFrom('md'),

                IsPersistentToggleColumn::make(),
                IsSkippableToggleColumn::make(),
                IsActiveToggleColumn::make(),
            ])
            ->headerActions([
                CreateAction::make(),
                AttachAction::make()
                    ->icon(Heroicon::ArrowsPointingIn)
                    ->recordSelectOptionsQuery(fn (Builder $query) => $query->usable())
                    ->multiple()
                    ->recordTitleAttribute('name')
                    ->preloadRecordSelect(),
            ])
            ->recordUrl(fn ($record) => Terms::getConditionResource()::getUrl('edit', ['record' => $record]))
            ->recordActions([
                \Filament\Actions\DetachAction::make()->iconButton()->icon(Heroicon::ArrowsPointingOut),

            ])
            ->modelLabel(__('betta-terms::models.condition.singular'))
            ->pluralModelLabel(__('betta-terms::models.condition.plural'));
    }

    public static function getTitle(Model $ownerRecord, string $pageClass): string
    {
        return __('betta-terms::models.condition.plural');
    }
}
