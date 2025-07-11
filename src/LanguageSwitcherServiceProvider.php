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

        // Register view composer
        $this->registerViewComposer();

        // Register middleware
        $this->registerMiddleware();

        // Register routes
        $this->registerRoutes();
    }

    /**
     * Register view composer
     */
    private function registerViewComposer(): void
    {
        \Illuminate\Support\Facades\View::composer('language-switcher::language-switcher', function ($view) {
            $view->with([
                'currentLanguage' => \Umbalaconmeogia\LanguageSwitcher\Enums\Language::getCurrent(),
                'currentDisplayName' => \Umbalaconmeogia\LanguageSwitcher\Enums\Language::getDisplayName(\Umbalaconmeogia\LanguageSwitcher\Enums\Language::getCurrent()),
                'supportedLanguages' => \Umbalaconmeogia\LanguageSwitcher\Enums\Language::getSupportedLanguages(),
            ]);
        });
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