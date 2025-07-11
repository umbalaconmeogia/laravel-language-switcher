<?php

namespace Umbalaconmeogia\LanguageSwitcher\Tests\Feature\Api;

use Orchestra\Testbench\TestCase;
use Umbalaconmeogia\LanguageSwitcher\LanguageSwitcherServiceProvider;
use Umbalaconmeogia\LanguageSwitcher\Enums\Language;
use Illuminate\Support\Facades\Route;

class LanguageApiControllerTest extends TestCase
{
    protected function getPackageProviders($app)
    {
        return [
            LanguageSwitcherServiceProvider::class,
        ];
    }

    protected function getEnvironmentSetUp($app)
    {
        $app['config']->set('language-switcher.api.enabled', true);
        $app['config']->set('language-switcher.supported_languages', [
            'en' => 'English',
            'ja' => '日本語',
            'vi' => 'Tiếng Việt',
        ]);
        $app['config']->set('language-switcher.default_language', 'en');
        $app['config']->set('language-switcher.fallback_language', 'en');
    }

    /** @test */
    public function it_can_get_current_language()
    {
        Route::languageSwitcherApi();
        $app = $this->app;
        $app->setLocale('ja');

        $response = $this->get('/api/languages/current');

        $response->assertStatus(200)
            ->assertJson([
                'current_language' => 'ja',
                'current_language_name' => '日本語',
            ])
            ->assertJsonStructure([
                'current_language',
                'current_language_name',
                'timestamp',
                'metadata' => [
                    'detection_method',
                    'session_key',
                    'default_language',
                    'fallback_language',
                ],
            ]);
    }

    /** @test */
    public function it_can_get_supported_languages()
    {
        Route::languageSwitcherApi();
        $response = $this->get('/api/languages/supported');

        $response->assertStatus(200)
            ->assertJson([
                'count' => 3,
                'default_language' => 'en',
                'fallback_language' => 'en',
            ])
            ->assertJsonStructure([
                'languages' => [
                    '*' => [
                        'code',
                        'name',
                        'is_default',
                        'is_fallback',
                    ],
                ],
                'count',
                'default_language',
                'fallback_language',
                'metadata' => [
                    'cache_enabled',
                    'cache_ttl',
                ],
            ]);

        $languages = $response->json('languages');
        $this->assertCount(3, $languages);
        
        // Check English is default
        $english = collect($languages)->firstWhere('code', 'en');
        $this->assertTrue($english['is_default']);
        $this->assertTrue($english['is_fallback']);
    }

    /** @test */
    public function it_can_switch_language_via_api()
    {
        Route::languageSwitcherApi();
        $app = $this->app;
        $app->setLocale('en');

        $response = $this->post('/api/languages/ja');

        $response->assertStatus(200)
            ->assertJson([
                'success' => true,
                'previous_language' => 'en',
                'new_language' => 'ja',
                'message' => 'Language switched to ja',
            ])
            ->assertJsonStructure([
                'success',
                'previous_language',
                'new_language',
                'message',
                'timestamp',
            ]);

        $this->assertEquals('ja', $app->getLocale());
        $this->assertEquals('ja', session('locale'));
    }

    /** @test */
    public function it_rejects_unsupported_language()
    {
        Route::languageSwitcherApi();
        $response = $this->post('/api/languages/unsupported');

        $response->assertStatus(400)
            ->assertJson([
                'error' => 'Unsupported language',
                'message' => "Language 'unsupported' is not supported",
            ])
            ->assertJsonStructure([
                'error',
                'message',
                'supported_languages',
            ]);

        $this->assertContainsEquals('en', $response->json('supported_languages'));
        $this->assertContainsEquals('ja', $response->json('supported_languages'));
        $this->assertContainsEquals('vi', $response->json('supported_languages'));
    }

    /** @test */
    public function it_includes_redirect_url_when_provided()
    {
        Route::languageSwitcherApi();
        $response = $this->post('/api/languages/ja', [
            'redirect_url' => '/dashboard',
        ]);

        $response->assertStatus(200)
            ->assertJson([
                'redirect_url' => '/dashboard',
            ]);
    }

    /** @test */
    public function it_respects_api_disabled_setting()
    {
        $this->app['config']->set('language-switcher.api.enabled', false);

        $response = $this->get('/api/languages/current');
        $this->assertSame(404, $response->getStatusCode());

        $response = $this->get('/api/languages/supported');
        $this->assertSame(404, $response->getStatusCode());

        $response = $this->post('/api/languages/ja');
        $this->assertSame(404, $response->getStatusCode());
    }
} 