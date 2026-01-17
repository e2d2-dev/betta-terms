<?php

namespace Betta\Terms;

use Betta\Terms\Actions\Condition\ActivateSuccessor;
use Betta\Terms\Actions\Condition\Replace;
use Betta\Terms\Actions\Consent\Create;
use Betta\Terms\Actions\Consent\CreatePersistent;
use Betta\Terms\Actions\Model\ModelConsentSlug;
use Betta\Terms\Actions\Model\UpdateConsentGuardConditions;
use Betta\Terms\Commands\MakeConditionCommand;
use Betta\Terms\Commands\MakeGuardCommand;
use Betta\Terms\Commands\MakeModelCommand;
use Betta\Terms\Commands\SetupCommand;
use Betta\Terms\Contracts\ActivatesSuccessor;
use Betta\Terms\Contracts\GeneratesModelConsentSlug;
use Betta\Terms\Contracts\ReplacesCondition;
use Betta\Terms\Contracts\CreateConsent;
use Betta\Terms\Contracts\UpdatesConsentGuardConditions;
use Betta\Terms\Filament\Auth\Register;
use Betta\Terms\Models\Condition;
use Illuminate\Support\ServiceProvider as BaseServiceProvider;

class ServiceProvider extends BaseServiceProvider
{
    public function getPackageName(): string
    {
        return 'betta-terms';
    }

    public function boot(): void
    {
        $this->mergeConfigFrom($this->getConfigPath(), $this->getPackageName());

        $this->loadViewsFrom($this->getViewPath(), $this->getPackageName());

        $this->loadTranslationsFrom($this->getTranslationPath(), $this->getPackageName());

        $this->app->singleton(TermsManager::class);

        $this->app->singleton(ModelRegistry::class);

        $this->app->singleton(ComponentRegistry::class);

        ComponentRegistry::make()->add(Register::class);

        $this->commands([
            SetupCommand::class,
            MakeGuardCommand::class,
            MakeConditionCommand::class,
            MakeModelCommand::class,
        ]);

        $this->publishes([
            $this->getConfigPath() => config_path('betta-terms.php'),
        ], 'config');

        $this->publishes([
            $this->getTranslationPath() => lang_path('vendor/betta-terms'),
        ], 'translations');

        $this->publishes([
            $this->getViewPath() => resource_path('views/vendor/betta-terms'),
        ], 'views');

        $this->app->bind(CreateConsent::class, function ($app, array $arguments): CreateConsent {
            /** @var Condition $condition */
            $condition = $arguments['condition'];

            $action = $condition->guardConfig->isPersistent()
                ? CreatePersistent::class
                : Create::class;

            return new $action;
        });

        $this->app->bind(ReplacesCondition::class, Replace::class);
        $this->app->bind(ActivatesSuccessor::class, ActivateSuccessor::class);
        $this->app->bind(UpdatesConsentGuardConditions::class, UpdateConsentGuardConditions::class);
        $this->app->bind(GeneratesModelConsentSlug::class, ModelConsentSlug::class);
    }

    public function getViewPath(): string
    {
        return __DIR__.'/../resources/views';
    }

    public function getTranslationPath(): string
    {
        return __DIR__.'/../resources/lang';
    }

    public function getConfigPath(): string
    {
        return __DIR__.'/../config/betta-terms.php';
    }
}
