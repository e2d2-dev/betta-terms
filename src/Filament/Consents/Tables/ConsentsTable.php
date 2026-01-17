<?php

namespace Betta\Terms\Filament\Consents\Tables;

use Betta\Terms\Filament\Tables\Columns\CreatedColumn;
use Betta\Terms\Filament\Tables\Columns\SignedOnColumn;
use Betta\Terms\Models\Consent;
use Betta\Terms\Terms;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class ConsentsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->modifyQueryUsing(fn (Builder $query) => $query->orderBy('created_at', 'desc'))
            ->columns([
                TextColumn::make('user.email')
                    ->grow()
                    ->sortable()
                    ->label(__('betta-terms::fields.email.label'))
                    ->searchable('email'),

                TextColumn::make('condition.name')
                    ->label(__('betta-terms::models.condition.singular'))
                    ->searchable()
                    ->sortable(),

                SignedOnColumn::make()
                    ->searchable()
                    ->sortable()
                    ->alignEnd(),

                CreatedColumn::make()
                    ->sortable()
                    ->alignEnd(),
            ])
            ->recordUrl(
                /** @param Consent $record */
                fn ($record) => Terms::getConditionResource()::getUrl('edit', [
                    'record' => $record->condition,
                    'relation' => 'consents',
                ]));

    }
}
