<?php

namespace Umbalaconmeogia\LanguageSwitcher;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Route;

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

        // Register routes
        $this->registerRoutes();
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