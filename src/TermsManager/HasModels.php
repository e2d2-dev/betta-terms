<?php

namespace Betta\Terms\TermsManager;

use App\Models\User;
use Betta\Terms\Models\Condition;
use Betta\Terms\Models\ConditionGuard;
use Betta\Terms\Models\Consent;
use Betta\Terms\Models\Guard;
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

    /** @return class-string<Guard> */
    public function getGuardModel(): string
    {
        return $this->getModel('guard');
    }

    /** @return class-string<Condition> */
    public function getConditionModel(): string
    {
        return $this->getModel('condition');
    }

    /** @return class-string<ConditionGuard> */
    public function getConditionGuardModel(): string
    {
        return $this->getModel('condition_guard');
    }

    /** @return class-string<Consent> */
    public function getConsentModel(): string
    {
        return $this->getModel('consent');
    }

    /** @return class-string<User> */
    public function getUserModel(): string
    {
        return $this->getModel('user');
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
