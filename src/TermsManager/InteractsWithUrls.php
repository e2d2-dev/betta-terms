<?php

namespace Betta\Terms\TermsManager;

use Betta\Terms\Terms;
use Betta\Terms\TermsManager\Url\HasConsentUrl;
use Betta\Terms\TermsManager\Url\HasIntendedUrl;

trait InteractsWithUrls
{
    use HasConsentUrl;
    use HasIntendedUrl;

    public function getNextUrl(): string
    {
        if (Terms::hasNextSessionGuard()) {
            return $this->getConsentUrl();
        }

        $url = $this->getIntendedUrl() ?: filament()->getUrl();

        if ($this->hasIntendedUrl()) {
            $this->clearIntendedUrl();
        }

        return $url;
    }
}
