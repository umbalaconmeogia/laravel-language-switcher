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
        return Config::get('language-switcher.default_language', self::ENGLISH);
    }

    /**
     * Get fallback language code
     */
    public static function getFallback(): string
    {
        return Config::get('language-switcher.fallback_language', self::ENGLISH);
    }

    /**
     * Get language detection method
     */
    public static function getDetectionMethod(): string
    {
        return Config::get('language-switcher.detection_method', 'all');
    }

    /**
     * Get URL parameter name
     */
    public static function getUrlParameter(): string
    {
        return Config::get('language-switcher.url_parameter', 'locale');
    }

    /**
     * Check if route prefixing is enabled
     */
    public static function isRoutePrefixEnabled(): bool
    {
        return Config::get('language-switcher.route_prefix', false);
    }

    /**
     * Get cache configuration
     */
    public static function getCacheConfig(): array
    {
        return Config::get('language-switcher.cache', [
            'enabled' => true,
            'ttl' => 3600,
            'prefix' => 'language_switcher_',
        ]);
    }

    /**
     * Check if caching is enabled
     */
    public static function isCachingEnabled(): bool
    {
        $config = self::getCacheConfig();
        return $config['enabled'] ?? true;
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