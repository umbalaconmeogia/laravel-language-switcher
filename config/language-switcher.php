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
]; 