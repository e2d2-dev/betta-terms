<?php

namespace Betta\Terms\Contracts;

interface GeneratesModelConsentSlug
{
    public function generate(ModelConditions $record): string;
}
