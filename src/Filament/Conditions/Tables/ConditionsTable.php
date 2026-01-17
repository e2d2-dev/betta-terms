<?php

namespace Betta\Terms\Filament\Conditions\Tables;

use Betta\Terms\Filament\Conditions\Actions\DeleteAction;
use Betta\Terms\Filament\Conditions\Tables\Columns\RevisionColumn;
use Betta\Terms\Filament\Conditions\Tables\Filters\GuardFilter;
use Betta\Terms\Filament\Tables\Columns\ConsentCountColumn;
use Betta\Terms\Filament\Tables\Columns\CreatedColumn;
use Betta\Terms\Filament\Tables\Columns\SourceColumn;
use Betta\Terms\Terms;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class ConditionsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->modifyQueryUsing(fn (Builder $query) => $query->orderBy('updated_at', 'desc'))
            ->columns([
                TextColumn::make('name')
                    ->searchable()
                    ->sortable()
                    ->grow(),

                ConsentCountColumn::make()
                    ->icon(Terms::getConfig('resources.consent.icon'))
                    ->sortable()
                    ->alignEnd(),

                RevisionColumn::make()
                    ->sortable()
                    ->visibleFrom('md'),

                SourceColumn::make()
                    ->sortable()
                    ->grow(false)
                    ->alignEnd(),

                CreatedColumn::make()
                    ->sortable()
                    ->visibleFrom('md')
                    ->alignEnd()
                    ->grow(false),

            ])
            ->recordActions([
                DeleteAction::make()
                    ->iconButton(),
            ])
            ->filters([
                GuardFilter::make(),
            ]);
    }
}
