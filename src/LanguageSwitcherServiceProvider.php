<?php

namespace Umbalaconmeogia\LanguageSwitcher;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Blade;

class LanguageSwitcherServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        // Register configuration
        $this->mergeConfigFrom(
            __DIR__.'/../config/language-switcher.php', 'language-switcher'
        );
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        // Publish configuration
        $this->publishes([
            __DIR__.'/../config/language-switcher.php' => config_path('language-switcher.php'),
        ], 'language-switcher-config');

        // Load views
        $this->loadViewsFrom(__DIR__.'/../resources/views', 'language-switcher');

        // Register Blade component
        Blade::componentNamespace('Umbalaconmeogia\\LanguageSwitcher\\View\\Components', 'language-switcher');

        // Register middleware
        $this->registerMiddleware();

        // Register routes
        $this->registerRoutes();
    }

    /**
     * Register middleware
     */
    private function registerMiddleware(): void
    {
        $this->app['router']->aliasMiddleware('setlocale', \Umbalaconmeogia\LanguageSwitcher\Middleware\SetLocale::class);
    }

    /**
     * Register routes
     */
    private function registerRoutes(): void
    {
        Route::macro('languageSwitcher', function () {
            Route::post('/language-switcher/{locale}', [\Umbalaconmeogia\LanguageSwitcher\Controllers\LanguageController::class, 'switch'])
                ->name('language.switch');
        });
    }
} 