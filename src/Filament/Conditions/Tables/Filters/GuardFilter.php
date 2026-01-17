<?php

namespace Betta\Terms\Filament\Conditions\Tables\Filters;

use Betta\Terms\Terms;
use Filament\Forms\Components\Select;
use Filament\Tables\Filters\Filter;
use Illuminate\Database\Eloquent\Builder;

class GuardFilter extends Filter
{
    public static function getDefaultName(): ?string
    {
        return 'guards';
    }

    protected function setUp(): void
    {
        parent::setUp();

        $this->schema([
            Select::make('guards')
                ->options(
                    Terms::getGuardModel()::query()
                        ->pluck('name', 'id')
                )
                ->label(__('betta-terms::models.guard.plural'))
                ->multiple()
                ->searchable(),
        ]);

        $this->modifyQueryUsing(function (Builder $query, array $data): Builder {
            return $query
                ->when(
                    !empty($data['guards']),
                    fn (Builder $query) => $query->whereHas(
                        'guards',
                        fn (Builder $query) => $query->whereIn('guard_id', $data['guards']))
                );
        });
    }
}
