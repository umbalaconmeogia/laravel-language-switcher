<?php

namespace Umbalaconmeogia\LanguageSwitcher\Tests;

use Umbalaconmeogia\LanguageSwitcher\Enums\Language;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class LanguageTest extends TestCase
{
    use RefreshDatabase;

    public function test_supported_languages_are_loaded_from_config()
    {
        $languages = Language::getSupportedLanguages();
        
        $this->assertIsArray($languages);
        $this->assertArrayHasKey('en', $languages);
        $this->assertArrayHasKey('ja', $languages);
        $this->assertArrayHasKey('vi', $languages);
    }

    public function test_get_display_name_returns_correct_name()
    {
        $this->assertEquals('English', Language::getDisplayName('en'));
        $this->assertEquals('日本語', Language::getDisplayName('ja'));
        $this->assertEquals('Tiếng Việt', Language::getDisplayName('vi'));
    }

    public function test_is_supported_returns_correct_boolean()
    {
        $this->assertTrue(Language::isSupported('en'));
        $this->assertTrue(Language::isSupported('ja'));
        $this->assertTrue(Language::isSupported('vi'));
        $this->assertFalse(Language::isSupported('fr'));
        $this->assertFalse(Language::isSupported('invalid'));
    }

    public function test_get_default_returns_configured_default()
    {
        $default = Language::getDefault();
        $this->assertEquals('ja', $default);
    }

    public function test_get_fallback_returns_configured_fallback()
    {
        $fallback = Language::getFallback();
        $this->assertEquals('en', $fallback);
    }

    public function test_get_supported_codes_returns_array_of_codes()
    {
        $codes = Language::getSupportedCodes();
        
        $this->assertIsArray($codes);
        $this->assertContains('en', $codes);
        $this->assertContains('ja', $codes);
        $this->assertContains('vi', $codes);
    }

    public function test_get_current_returns_application_locale()
    {
        app()->setLocale('en');
        $this->assertEquals('en', Language::getCurrent());
        
        app()->setLocale('ja');
        $this->assertEquals('ja', Language::getCurrent());
    }

    public function test_is_current_default_returns_correct_boolean()
    {
        app()->setLocale('ja');
        $this->assertTrue(Language::isCurrentDefault());
        
        app()->setLocale('en');
        $this->assertFalse(Language::isCurrentDefault());
    }
} 