<?php

namespace Betta\Terms\TermsManager;

trait HasMiddleware
{
    public function getPanelConsentMiddleware(): string
    {
        return $this->getConfig('middleware.panel');
    }
}
