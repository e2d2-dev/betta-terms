<?php

namespace Betta\Terms\Filament\Consents\Pages;

use Betta\Terms\Terms;
use Filament\Resources\Pages\ListRecords;

class ListConsents extends ListRecords
{
    public static function getResource(): string
    {
        return Terms::getConsentResource();
    }
}
