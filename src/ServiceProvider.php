<?php

namespace Betta\Terms;

use Betta\Terms\Commands\MakeConditionCommand;
use Betta\Terms\Commands\MakeGuardCommand;
use Betta\Terms\Commands\MakeModelCommand;
use Betta\Terms\Commands\SetupCommand;
use Betta\Terms\Filament\Auth\Register;
use Illuminate\Support\ServiceProvider as BaseServiceProvider;
use function Illuminate\Filesystem\join_paths;

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
            $this->getViewPath()  => resource_path('views/vendor/betta-terms'),
        ], 'views');
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
