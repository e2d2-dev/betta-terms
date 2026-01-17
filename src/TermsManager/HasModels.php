<?php

namespace Betta\Terms\TermsManager;

use Closure;
use Illuminate\Database\Eloquent\Model;

trait HasModels
{
    protected ?Closure $generateModelSlugUsing = null;

    /** @return ?class-string<Model> */
    public function getModel(string $name): ?string
    {
        return $this->getConfig("models.{$name}");
    }

    public function getModelSlug(string $class): string
    {
        $using = $this->generateModelSlugUsing;

        if ($using instanceof Closure) {
            return $using($class);
        }

        return str($class)->afterLast('\\')->snake()->prepend($this->getModelSlugPrefix())->toString();
    }

    public function generateModelSlugUsing(Closure $callback): static
    {
        $this->generateModelSlugUsing = $callback;

        return $this;
    }

    public function getModelSlugPrefix(): string
    {
        return $this->getConfig('slug.model.prefix', 'model//');
    }
}
