<?php

namespace Betta\Terms\Actions\Model;

use Betta\Terms\Contracts\GeneratesModelConsentSlug;
use Betta\Terms\Contracts\ModelConditions;

class ModelConsentSlug implements GeneratesModelConsentSlug
{
    public function generate(ModelConditions $record): string
    {
        $key = $record->getKey();
        $class = get_class($record);

        return "$key@$class";
    }
}
