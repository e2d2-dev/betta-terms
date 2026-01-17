<?php

namespace Betta\Terms\Filament\Conditions\RelationManagers;

use Betta\Onboarding\Filament\Progress\Tables\Columns\EmailColumn;
use Betta\Terms\Filament\Tables\Columns\CreatedColumn;
use Betta\Terms\Filament\Tables\Columns\NameColumn;
use Betta\Terms\Models\Condition;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DetachAction;
use Filament\Actions\DetachBulkAction;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Model;

/**
 * @method Condition getOwnerRecord()
 */
class ConsentsRelationManager extends RelationManager
{
    protected static string $relationship = 'consents';

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('name')
            ->columns([
                NameColumn::make()
                    ->searchable(),
                EmailColumn::make()
                    ->searchable()
                    ->grow(),
                CreatedColumn::make(),
            ])
            ->filters([
                //
            ])
            ->headerActions([
            ])
            ->recordActions([
                DetachAction::make()
                    ->label(__('betta-terms::actions.reset.label'))
                    ->disabled(fn (ConsentsRelationManager $livewire) => $livewire->getOwnerRecord()->isObsolete())
                    ->requiresConfirmation(),
            ])
            ->headerActions([
                BulkActionGroup::make([
                    DetachBulkAction::make()
                        ->requiresConfirmation()
                        ->disabled(fn (ConsentsRelationManager $livewire) => $livewire->getOwnerRecord()->isObsolete()),
                ]),
            ]);
    }

    public static function getModelLabel(): ?string
    {
        return __('betta-terms::models.user.singular');
    }

    public static function getPluralModelLabel(): ?string
    {
        return __('betta-terms::models.user.plural');
    }

    public static function getTitle(Model $ownerRecord, string $pageClass): string
    {
        return __('betta-terms::fields.consent.label');
    }

    /**
     * @param  Condition  $ownerRecord
     */
    public static function getBadge(Model $ownerRecord, string $pageClass): ?string
    {
        return $ownerRecord->consents()->count();
    }
}
