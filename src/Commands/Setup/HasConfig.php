<?php

namespace Betta\Terms\Commands\Setup;

trait HasConfig
{
    protected array $config;

    protected function loadConfig(): void
    {
        $this->config = require __DIR__.'/../../../config/betta-terms.php';
    }
}
