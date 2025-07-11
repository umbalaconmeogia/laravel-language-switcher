<?php

namespace Umbalaconmeogia\LanguageSwitcher\Tests;

use Umbalaconmeogia\LanguageSwitcher\Controllers\LanguageController;
use Umbalaconmeogia\LanguageSwitcher\Enums\Language;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Request;
use Tests\TestCase;

class LanguageControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_switch_language_with_valid_locale()
    {
        $controller = new LanguageController();
        $request = Request::create('/language/en', 'POST');
        $request->setLaravelSession(app('session.store'));

        $response = $controller->switch($request, 'en');

        $this->assertEquals(302, $response->getStatusCode());
        $this->assertEquals('en', session('locale'));
    }

    public function test_switch_language_with_invalid_locale()
    {
        $controller = new LanguageController();
        $request = Request::create('/language/invalid', 'POST');
        $request->setLaravelSession(app('session.store'));

        $response = $controller->switch($request, 'invalid');

        $this->assertEquals(302, $response->getStatusCode());
        $this->assertNull(session('locale'));
    }

    public function test_current_method_returns_correct_data()
    {
        $controller = new LanguageController();
        app()->setLocale('ja');

        $data = $controller->current();

        $this->assertIsArray($data);
        $this->assertEquals('ja', $data['current']);
        $this->assertEquals('ja', $data['default']);
        $this->assertArrayHasKey('supported', $data);
        $this->assertTrue($data['is_default']);
    }

    public function test_supported_method_returns_correct_data()
    {
        $controller = new LanguageController();

        $data = $controller->supported();

        $this->assertIsArray($data);
        $this->assertArrayHasKey('languages', $data);
        $this->assertArrayHasKey('codes', $data);
        $this->assertArrayHasKey('en', $data['languages']);
        $this->assertArrayHasKey('ja', $data['languages']);
        $this->assertArrayHasKey('vi', $data['languages']);
        $this->assertContains('en', $data['codes']);
        $this->assertContains('ja', $data['codes']);
        $this->assertContains('vi', $data['codes']);
    }
} 