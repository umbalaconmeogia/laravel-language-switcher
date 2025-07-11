<?php

namespace Umbalaconmeogia\LanguageSwitcher;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Console\Application as ArtisanApplication;
use Umbalaconmeogia\LanguageSwitcher\Events\LanguageChanged;
use Umbalaconmeogia\LanguageSwitcher\Listeners\LogLanguageChange;
use Umbalaconmeogia\LanguageSwitcher\Console\Commands\PublishLanguageSwitcher;
use Umbalaconmeogia\LanguageSwitcher\Console\Commands\ListSupportedLanguages;
use Umbalaconmeogia\LanguageSwitcher\Console\Commands\ClearLanguageCache;

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

        // Register event listeners
        $this->registerEventListeners();

        // Register console commands
        $this->registerCommands();
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        // Publish assets and configuration
        $this->publishAssets();

        // Load views
        $this->loadViewsFrom(__DIR__.'/../resources/views', 'language-switcher');

        // Register Blade component
        Blade::componentNamespace('Umbalaconmeogia\\LanguageSwitcher\\View\\Components', 'language-switcher');

        // Register middleware
        $this->registerMiddleware();

        // Register routes
        $this->registerRoutes();

        // Register conditional assets
        $this->registerConditionalAssets();

        // Share data with all views
        $this->shareViewData();
    }

    /**
     * Publish assets and configuration
     */
    private function publishAssets(): void
    {
        // Publish configuration
        $this->publishes([
            __DIR__.'/../config/language-switcher.php' => config_path('language-switcher.php'),
        ], 'language-switcher-config');

        // Publish views
        $this->publishes([
            __DIR__.'/../resources/views' => resource_path('views/vendor/language-switcher'),
        ], 'language-switcher-views');

        // Publish CSS assets
        $this->publishes([
            __DIR__.'/../resources/css' => public_path('vendor/language-switcher/css'),
        ], 'language-switcher-assets');

        // Publish all assets
        $this->publishes([
            __DIR__.'/../config/language-switcher.php' => config_path('language-switcher.php'),
            __DIR__.'/../resources/views' => resource_path('views/vendor/language-switcher'),
            __DIR__.'/../resources/css' => public_path('vendor/language-switcher/css'),
        ], 'language-switcher');
    }

    /**
     * Register event listeners
     */
    private function registerEventListeners(): void
    {
        Event::listen(
            LanguageChanged::class,
            [LogLanguageChange::class, 'handle']
        );
    }

    /**
     * Register console commands
     */
    private function registerCommands(): void
    {
        if ($this->app->runningInConsole()) {
            $this->commands([
                PublishLanguageSwitcher::class,
                ListSupportedLanguages::class,
                ClearLanguageCache::class,
            ]);
        }
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
        // Web routes
        Route::macro('languageSwitcher', function () {
            Route::post('/language-switcher/{locale}', [\Umbalaconmeogia\LanguageSwitcher\Controllers\LanguageController::class, 'switch'])
                ->name('language.switch');
        });

        // API routes (if enabled)
        if (config('language-switcher.api.enabled', true)) {
            Route::macro('languageSwitcherApi', function () {
                Route::prefix('api/languages')->group(function () {
                    Route::get('/current', [\Umbalaconmeogia\LanguageSwitcher\Controllers\Api\LanguageApiController::class, 'current'])
                        ->name('api.languages.current');
                    Route::get('/supported', [\Umbalaconmeogia\LanguageSwitcher\Controllers\Api\LanguageApiController::class, 'supported'])
                        ->name('api.languages.supported');
                    Route::post('/{locale}', [\Umbalaconmeogia\LanguageSwitcher\Controllers\Api\LanguageApiController::class, 'switch'])
                        ->name('api.languages.switch');
                });
            });
        }
    }

    /**
     * Register conditional assets
     */
    private function registerConditionalAssets(): void
    {
        // Register Blade directives for manual CSS inclusion
        $this->registerBladeDirectives();
    }

    /**
     * Register Blade directives
     */
    private function registerBladeDirectives(): void
    {
        // Register @languageSwitcherStyles directive
        Blade::directive('languageSwitcherStyles', function ($expression) {
            $style = $expression ?: "'" . config('language-switcher.component.default_style', 'default') . "'";
            return "<?php echo '<link rel=\"stylesheet\" href=\"" . asset("vendor/language-switcher/css/language-switcher-{$style}.css") . "\">'; ?>";
        });
    }

    /**
     * Share data with all views
     */
    private function shareViewData(): void
    {
        View::composer('*', function ($view) {
            $view->with('currentLanguage', app()->getLocale());
            $view->with('supportedLanguages', config('language-switcher.supported_languages', []));
        });
    }

    /**
     * Check if current request is an API request
     */
    private function isApiRequest(): bool
    {
        return request()->expectsJson() || 
               request()->is('api/*') || 
               request()->header('Accept') === 'application/json';
    }
} 