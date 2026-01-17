<?php

namespace Betta\Terms\TermsManager\Panels;

use Closure;

trait HasPanelSlug
{
    protected ?Closure $generatePanelSlugUsing = null;

    public function getPanelSlug(string $panel): string
    {
        $using = $this->generatePanelSlugUsing;

        if ($using instanceof Closure) {
            return $using($panel);
        }

        return str($panel)->prepend($this->getPanelSlugPrefix())->toString();
    }

    public function generatePanelSlugUsing(Closure $callback): static
    {
        $this->generatePanelSlugUsing = $callback;

        return $this;
    }

    public function getPanelSlugPrefix(): string
    {
        return $this->getConfig('slug.panel.prefix', 'panel//');
    }
}
