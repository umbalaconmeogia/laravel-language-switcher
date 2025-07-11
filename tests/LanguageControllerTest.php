<?php

namespace Umbalaconmeogia\LanguageSwitcher\Tests;

use Illuminate\Support\Facades\Route;
use Orchestra\Testbench\TestCase;
use Illuminate\Support\Facades\Session;
use Illuminate\Http\Request;
use Umbalaconmeogia\LanguageSwitcher\Controllers\LanguageController;

class LanguageControllerTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        // Register the route for testing
        Route::post('/language-switcher/{locale}', [LanguageController::class, 'switch'])->name('language.switch');
    }

    public function test_switch_to_supported_language_sets_session_and_locale()
    {
        $response = $this->post(route('language.switch', ['locale' => 'ja']));
        $response->assertRedirect();
        $this->assertEquals('ja', session('locale'));
        $this->assertEquals('ja', app()->getLocale());
    }

    public function test_switch_to_unsupported_language_does_not_change_locale()
    {
        session(['locale' => 'en']);
        app()->setLocale('en');
        $response = $this->post(route('language.switch', ['locale' => 'fr']));
        $response->assertRedirect();
        $this->assertEquals('en', session('locale'));
        $this->assertEquals('en', app()->getLocale());
    }
} 