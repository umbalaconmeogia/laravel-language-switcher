<?php

namespace Umbalaconmeogia\LanguageSwitcher;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Blade;
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

        // Publish views
        $this->publishes([
            __DIR__.'/../resources/views' => resource_path('views/vendor/laravel-language-switcher'),
        ], 'language-switcher-views');

        // Publish language files
        $this->publishes([
            __DIR__.'/../resources/lang' => resource_path('lang/vendor/laravel-language-switcher'),
        ], 'language-switcher-lang');

        // Publish CSS files
        $this->publishes([
            __DIR__.'/../resources/css/language-switcher.css' => resource_path('css/vendor/laravel-language-switcher/language-switcher.css'),
        ], 'language-switcher-css');

        // Load views
        $this->loadViewsFrom(__DIR__.'/../resources/views', 'language-switcher');

        // Load language files
        $this->loadTranslationsFrom(__DIR__.'/../resources/lang', 'language-switcher');

        // Register Blade components
        $this->registerBladeComponents();

        // Register routes
        $this->registerRoutes();
    }

    /**
     * Register Blade components
     */
    private function registerBladeComponents(): void
    {
        Blade::component('language-switcher::language-switcher', \Umbalaconmeogia\LanguageSwitcher\View\Components\LanguageSwitcher::class);
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