<?php

namespace Betta\Terms\Filament\Pages\ConsentConditions;

use Betta\Terms\Filament\Pages\ConsentConditions\Actions\HasCancelAction;
use Betta\Terms\Filament\Pages\ConsentConditions\Actions\HasSaveAction;

trait HasContentActions
{
    use HasCancelAction;
    use HasSaveAction;
}
