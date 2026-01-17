<?php

namespace Betta\Terms;

use Illuminate\Support\Facades\Facade;

class Terms extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return TermsManager::class;
    }
}
