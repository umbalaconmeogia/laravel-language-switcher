<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Supported Languages
    |--------------------------------------------------------------------------
    |
    | This array contains all supported languages for the application.
    | The key is the language code (ISO 639-1) and the value is the display name.
    |
    */
    'supported_languages' => [
        'en' => 'English',
        'ja' => '日本語',
        'vi' => 'Tiếng Việt',
    ],

    /*
    |--------------------------------------------------------------------------
    | Default Language
    |--------------------------------------------------------------------------
    |
    | This is the default language that will be used when no language
    | is specified or when the requested language is not supported.
    |
    */
    'default_language' => 'ja',

    /*
    |--------------------------------------------------------------------------
    | Fallback Language
    |--------------------------------------------------------------------------
    |
    | This is the fallback language that will be used when a translation
    | is not available in the current language.
    |
    */
    'fallback_language' => 'en',

    /*
    |--------------------------------------------------------------------------
    | Language Detection
    |--------------------------------------------------------------------------
    |
    | Configure how the package should detect the user's preferred language.
    | Options: 'session', 'url', 'header', 'all'
    |
    */
    'detection_method' => 'all',

    /*
    |--------------------------------------------------------------------------
    | Session Key
    |--------------------------------------------------------------------------
    |
    | The session key used to store the current language preference.
    |
    */
    'session_key' => 'locale',

    /*
    |--------------------------------------------------------------------------
    | URL Parameter
    |--------------------------------------------------------------------------
    |
    | The URL parameter name used to specify the language.
    |
    */
    'url_parameter' => 'locale',

    /*
    |--------------------------------------------------------------------------
    | Route Prefix
    |--------------------------------------------------------------------------
    |
    | Whether to prefix routes with the current language code.
    | This is useful for SEO and user experience.
    |
    */
    'route_prefix' => false,

    /*
    |--------------------------------------------------------------------------
    | Language Switcher
    |--------------------------------------------------------------------------
    |
    | Configuration for the language switcher component.
    |
    */
    'switcher' => [
        'show_current' => true,
        'show_flags' => false,
        'dropdown_style' => 'default', // 'default', 'minimal', 'custom'
        'mobile_friendly' => true,
    ],

    /*
    |--------------------------------------------------------------------------
    | Cache
    |--------------------------------------------------------------------------
    |
    | Whether to cache language configurations and translations.
    |
    */
    'cache' => [
        'enabled' => true,
        'ttl' => 3600, // 1 hour
    ],
]; 