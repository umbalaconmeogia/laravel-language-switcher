<?php

namespace Umbalaconmeogia\LanguageSwitcher\Enums;

use Illuminate\Support\Facades\Config;

class Language
{
    public const ENGLISH = 'en';
    public const JAPANESE = 'ja';
    public const VIETNAMESE = 'vi';

    /**
     * Get supported languages from configuration
     */
    public static function getSupportedLanguages(): array
    {
        return Config::get('language-switcher.supported_languages', [
            self::ENGLISH => 'English',
            self::JAPANESE => '日本語',
            self::VIETNAMESE => 'Tiếng Việt',
        ]);
    }

    /**
     * Get display name for language code
     */
    public static function getDisplayName(string $code): string
    {
        $languages = self::getSupportedLanguages();
        return $languages[$code] ?? $code;
    }

    /**
     * Check if language code is supported
     */
    public static function isSupported(string $code): bool
    {
        $languages = self::getSupportedLanguages();
        return array_key_exists($code, $languages);
    }

    /**
     * Get default language code
     */
    public static function getDefault(): string
    {
        return Config::get('language-switcher.default_language', self::JAPANESE);
    }

    /**
     * Get fallback language code
     */
    public static function getFallback(): string
    {
        return Config::get('language-switcher.fallback_language', self::ENGLISH);
    }

    /**
     * Get all supported language codes
     */
    public static function getSupportedCodes(): array
    {
        return array_keys(self::getSupportedLanguages());
    }

    /**
     * Get current application locale
     */
    public static function getCurrent(): string
    {
        return app()->getLocale();
    }

    /**
     * Check if current language is the default language
     */
    public static function isCurrentDefault(): bool
    {
        return self::getCurrent() === self::getDefault();
    }
} 