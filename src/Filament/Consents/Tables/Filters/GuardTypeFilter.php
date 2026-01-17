<?php

namespace Betta\Terms\Filament\Consents\Tables\Filters;

use Betta\Terms\Enums\GuardType;
use Betta\Terms\Terms;
use Filament\Forms\Components\Select;
use Filament\Tables\Filters\Filter;
use Illuminate\Database\Eloquent\Builder;

class GuardTypeFilter extends Filter
{
    public static function getDefaultName(): ?string
    {
        return 'guard_type';
    }

    protected function setUp(): void
    {
        parent::setUp();

        $this->schema([
            Select::make('type')
                ->options(GuardType::class),
        ]);

        $this->modifyQueryUsing(function (Builder $query, array $data): Builder {
            return $query
                ->when(
                    $data['type'] === GuardType::Panel->value,
                    fn (Builder $query) => $query->whereLike('signed_on', Terms::getPanelSlugPrefix().'%')
                )
                ->when(
                    $data['type'] === GuardType::Model->value,
                    fn (Builder $query) => $query->whereLike('signed_on', '%@%')
                );

        });
    }
}
