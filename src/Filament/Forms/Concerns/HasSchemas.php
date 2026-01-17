<?php

namespace Betta\Terms\Filament\Forms\Concerns;

use Betta\Terms\Filament\Forms\AcceptedCheckbox;
use Betta\Terms\Filament\Forms\ConditionSection;

trait HasSchemas
{
    public function getOpenConditionSchema(): array
    {
        return [
            ConditionSection::make(),
            AcceptedCheckbox::make(),
        ];
    }

    public function getCompactConditionSchema(): array
    {
        return [
            AcceptedCheckbox::make()
                ->compact(),
        ];
    }
}
