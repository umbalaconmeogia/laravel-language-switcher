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
    | Session Key
    |--------------------------------------------------------------------------
    |
    | The session key used to store the current language preference.
    |
    */
    'session_key' => 'locale',

    /*
    |--------------------------------------------------------------------------
    | Fallback Language
    |--------------------------------------------------------------------------
    |
    | This is the fallback language that will be used when the requested
    | language is not available or when there's an error.
    |
    */
    'fallback_language' => 'en',

    /*
    |--------------------------------------------------------------------------
    | Language Detection Method
    |--------------------------------------------------------------------------
    |
    | This determines how the language is detected. Options:
    | - 'session': Only use session-stored language preference
    | - 'url': Only use URL parameter for language detection
    | - 'header': Only use Accept-Language header
    | - 'all': Use all methods in order (session -> url -> header)
    |
    */
    'detection_method' => 'all',

    /*
    |--------------------------------------------------------------------------
    | URL Parameter Name
    |--------------------------------------------------------------------------
    |
    | The URL parameter name used for language detection.
    | Example: example.com?locale=en
    |
    */
    'url_parameter' => 'locale',

    /*
    |--------------------------------------------------------------------------
    | Route Prefix
    |--------------------------------------------------------------------------
    |
    | Whether to add language prefix to routes.
    | If true, routes will be prefixed with language code.
    | Example: /en/about, /ja/about, /vi/about
    |
    */
    'route_prefix' => false,

    /*
    |--------------------------------------------------------------------------
    | Cache Configuration
    |--------------------------------------------------------------------------
    |
    | Cache settings for language data and preferences.
    |
    */
    'cache' => [
        'enabled' => true,
        'ttl' => 3600, // Time to live in seconds
        'prefix' => 'language_switcher_',
    ],

    /*
    |--------------------------------------------------------------------------
    | Component Configuration
    |--------------------------------------------------------------------------
    |
    | Default settings for the language switcher component.
    |
    */
    'component' => [
        'default_style' => 'default',
        'show_flags' => false,
        'show_language_codes' => false,
        'dropdown_position' => 'bottom-right', // bottom-right, bottom-left, top-right, top-left
        'animation_duration' => 200, // milliseconds
    ],

    /*
    |--------------------------------------------------------------------------
    | Middleware Configuration
    |--------------------------------------------------------------------------
    |
    | Settings for the SetLocale middleware.
    |
    */
    'middleware' => [
        'auto_detect' => true,
        'store_in_session' => true,
        'redirect_on_change' => false,
        'exclude_paths' => [
            'api/*',
            'admin/*',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | API Configuration
    |--------------------------------------------------------------------------
    |
    | Settings for API endpoints and responses.
    |
    */
    'api' => [
        'enabled' => true,
        'endpoints' => [
            'current' => '/api/languages/current',
            'supported' => '/api/languages/supported',
            'switch' => '/api/languages/{locale}',
        ],
        'response_format' => 'json', // json, xml
        'include_metadata' => true,
    ],

    /*
    |--------------------------------------------------------------------------
    | Localization Files
    |--------------------------------------------------------------------------
    |
    | Configuration for language-specific files and assets.
    |
    */
    'localization' => [
        'auto_load' => true,
        'file_patterns' => [
            'translations' => 'lang/{locale}/*.php',
            'views' => 'resources/views/{locale}/*.blade.php',
            'assets' => 'public/assets/{locale}/*',
        ],
        'fallback_to_default' => true,
    ],

    /*
    |--------------------------------------------------------------------------
    | Security Configuration
    |--------------------------------------------------------------------------
    |
    | Security settings for language switching.
    |
    */
    'security' => [
        'csrf_protection' => true,
        'allowed_domains' => [],
        'rate_limiting' => [
            'enabled' => false,
            'max_attempts' => 10,
            'decay_minutes' => 1,
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Debug Configuration
    |--------------------------------------------------------------------------
    |
    | Debug settings for development and troubleshooting.
    |
    */
    'debug' => [
        'enabled' => false,
        'log_language_changes' => false,
        'show_detection_info' => false,
    ],
]; 