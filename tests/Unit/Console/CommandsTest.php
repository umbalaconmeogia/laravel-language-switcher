<?php

namespace Umbalaconmeogia\LanguageSwitcher\Tests\Unit\Console;

use Orchestra\Testbench\TestCase;
use Umbalaconmeogia\LanguageSwitcher\LanguageSwitcherServiceProvider;
use Umbalaconmeogia\LanguageSwitcher\Console\Commands\ListSupportedLanguages;
use Umbalaconmeogia\LanguageSwitcher\Console\Commands\ClearLanguageCache;

class CommandsTest extends TestCase
{
    protected function getPackageProviders($app)
    {
        return [
            LanguageSwitcherServiceProvider::class,
        ];
    }

    protected function getEnvironmentSetUp($app)
    {
        $app['config']->set('language-switcher.supported_languages', [
            'en' => 'English',
            'ja' => '日本語',
            'vi' => 'Tiếng Việt',
        ]);
        $app['config']->set('language-switcher.default_language', 'en');
        $app['config']->set('language-switcher.fallback_language', 'en');
        $app['config']->set('language-switcher.cache.enabled', true);
    }

    /** @test */
    public function list_supported_languages_command_works()
    {
        $command = new ListSupportedLanguages();
        
        // Test table format (default)
        $this->artisan('language-switcher:list')
            ->expectsOutput('Language Switcher Configuration')
            ->expectsOutput('==============================')
            ->expectsOutput('Default Language: en')
            ->expectsOutput('Fallback Language: en')
            ->assertExitCode(0);
    }

    /** @test */
    public function list_supported_languages_command_with_json_format()
    {
        $this->artisan('language-switcher:list', ['--format' => 'json'])
            ->assertExitCode(0);
    }

    /** @test */
    public function list_supported_languages_command_with_csv_format()
    {
        $this->artisan('language-switcher:list', ['--format' => 'csv'])
            ->expectsOutput('Code,Name')
            ->expectsOutput('en,English')
            ->expectsOutput('ja,日本語')
            ->expectsOutput('vi,Tiếng Việt')
            ->assertExitCode(0);
    }

    /** @test */
    public function clear_cache_command_works()
    {
        $this->artisan('language-switcher:clear-cache')
            ->expectsOutput('Clearing Language Switcher cache...')
            ->expectsOutput('✓ Cache cleared')
            ->expectsOutput('Language Switcher cache cleared successfully!')
            ->assertExitCode(0);
    }

    /** @test */
    public function clear_cache_command_with_all_option()
    {
        $this->artisan('language-switcher:clear-cache', ['--all' => true])
            ->expectsOutput('Clearing Language Switcher cache...')
            ->expectsOutput('✓ Cache cleared')
            ->expectsOutput('✓ Session clear instructions provided')
            ->expectsOutput('To clear session data, run: php artisan session:clear')
            ->expectsOutput('Language Switcher cache cleared successfully!')
            ->assertExitCode(0);
    }

    /** @test */
    public function clear_cache_command_when_cache_disabled()
    {
        $this->app['config']->set('language-switcher.cache.enabled', false);

        $this->artisan('language-switcher:clear-cache')
            ->expectsOutput('Clearing Language Switcher cache...')
            ->expectsOutput('No cache to clear (caching is disabled)')
            ->assertExitCode(0);
    }

    /** @test */
    public function publish_command_is_registered()
    {
        $this->artisan('language-switcher:publish', ['--help' => true])
            ->assertExitCode(0);
    }
} 