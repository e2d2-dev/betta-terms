<?php

namespace Betta\Terms\TermsManager;

trait HasConfig
{
    public function getConfig(string $key, mixed $default = null)
    {
        return config("betta-terms.{$key}", $default);
    }
}
