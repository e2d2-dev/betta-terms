<?php

namespace Betta\Terms\TermsManager;

trait HasTables
{
    public function getTable(string $name): string
    {
        return $this->getConfig("tables.{$name}");
    }
}
