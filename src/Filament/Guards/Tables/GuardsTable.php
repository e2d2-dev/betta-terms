<?php

namespace Betta\Terms\Filament\Guards\Tables;

use Betta\Terms\Filament\Guards\Tables\Columns\DisplayNameColumn;
use Betta\Terms\Filament\Tables\Columns\CreatedColumn;
use Betta\Terms\Terms;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class GuardsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                DisplayNameColumn::make()->grow(),

                TextColumn::make('slug'),

                TextColumn::make('conditions_count')
                    ->icon(Terms::getConfig('resources.condition.icon'))
                    ->label(__('betta-terms::models.condition.plural'))
                    ->alignEnd()
                    ->counts('conditions'),

                CreatedColumn::make()
                    ->visibleFrom('md')
                    ->grow(false)
                    ->alignEnd(),
            ]);
    }
}
