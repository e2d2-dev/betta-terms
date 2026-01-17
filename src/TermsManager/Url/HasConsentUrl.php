<?php

namespace Betta\Terms\TermsManager\Url;

use Betta\Terms\Filament\Pages\ConsentConditions;

trait HasConsentUrl
{
    protected ?string $consentPageComponent = null;

    public function onConsentUrl(): bool
    {
        return url()->current() === $this->getConsentUrl();
    }

    public function getConsentUrl(): ?string
    {
        return static::getConsentPageComponent()::getUrl();
    }

    public function consentPageComponent(?string $page = null): ?string
    {
        return $this->consentPageComponent = $page;
    }

    /** @return class-string<ConsentConditions> */
    public function getConsentPageComponent(): string
    {
        return $this->consentPageComponent ?? $this->getConfig('page.consent_conditions.component', ConsentConditions::class);
    }
}
