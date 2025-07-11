<?php

namespace Umbalaconmeogia\LanguageSwitcher\Tests;

use Umbalaconmeogia\LanguageSwitcher\Enums\Language;
use Orchestra\Testbench\TestCase;

class LanguageTest extends TestCase
{
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
        $this->assertSame('English', Language::getDisplayName('en'));
        $this->assertSame('日本語', Language::getDisplayName('ja'));
        $this->assertSame('Tiếng Việt', Language::getDisplayName('vi'));
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
        $this->assertSame('en', $default); // Adjust if your config default is different
    }

    public function test_get_fallback_returns_configured_fallback()
    {
        $fallback = Language::getFallback();
        $this->assertSame('en', $fallback); // Adjust if your config fallback is different
    }

    public function test_get_supported_codes_returns_array_of_codes()
    {
        $codes = Language::getSupportedCodes();
        $this->assertIsArray($codes);
        $this->assertContainsEquals('en', $codes);
        $this->assertContainsEquals('ja', $codes);
        $this->assertContainsEquals('vi', $codes);
    }

    public function test_get_current_returns_application_locale()
    {
        app()->setLocale('en');
        $this->assertSame('en', Language::getCurrent());
        app()->setLocale('ja');
        $this->assertSame('ja', Language::getCurrent());
    }

    public function test_is_current_default_returns_correct_boolean()
    {
        app()->setLocale(Language::getDefault());
        $this->assertTrue(Language::isCurrentDefault());
        app()->setLocale('vi');
        $this->assertFalse(Language::isCurrentDefault());
    }
} 