<?php

namespace Betta\Terms\Filament\Consents\Tables;

use Betta\Terms\Filament\Consents\Tables\Filters\GuardTypeFilter;
use Betta\Terms\Filament\Tables\Columns\CreatedColumn;
use Betta\Terms\Filament\Tables\Columns\EmailColumn;
use Betta\Terms\Filament\Tables\Columns\SignedOnColumn;
use Betta\Terms\Models\Consent;
use Betta\Terms\Terms;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\Layout\Split;
use Filament\Tables\Columns\Layout\Stack;
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
                Stack::make([
                    Split::make([
                        EmailColumn::make('user.email')
                            ->icon(Heroicon::User)
                            ->grow()
                            ->sortable()
                            ->searchable(),

                        TextColumn::make('condition.name')
                            ->label(__('betta-terms::models.condition.singular'))
                            ->searchable()
                            ->icon(Terms::getConfig('resources.condition.icon'))
                            ->alignEnd()
                            ->sortable(),
                    ]),
                    Split::make([
                        SignedOnColumn::make()
                            ->icon(Terms::getConfig('resources.guard.icon'))
                            ->searchable()
                            ->sortable(),

                        CreatedColumn::make()
                            ->sortable()
                            ->alignEnd(),
                    ]),
                ]),
            ])
            ->recordUrl(
                fn (Consent $record) => Terms::getConditionResource()::getUrl('edit', [
                    'record' => $record->condition,
                    'relation' => 'consents',
                ]))
            ->filters([
                GuardTypeFilter::make(),
            ]);

    }
}
