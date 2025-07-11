# Laravel Language Switcher

A simple, CSS framework independent Laravel package for language switching.

## Features

- ✅ **Simple & Lightweight** - No external dependencies
- ✅ **CSS Framework Independent** - Works with any CSS framework
- ✅ **Pure Blade** - No JavaScript required
- ✅ **Easy to Customize** - Simple CSS classes
- ✅ **Session-based** - Remembers language preference

## Installation

```bash
composer require umbalaconmeogia/laravel-language-switcher
```

## Configuration

### Quick Setup

Publish all assets and configuration:

```bash
php artisan language-switcher:publish
```

### Selective Publishing

Publish only specific assets:

```bash
# Configuration only
php artisan vendor:publish --provider="Umbalaconmeogia\LanguageSwitcher\LanguageSwitcherServiceProvider" --tag="language-switcher-config"

# Views only
php artisan vendor:publish --provider="Umbalaconmeogia\LanguageSwitcher\LanguageSwitcherServiceProvider" --tag="language-switcher-views"

# CSS assets only
php artisan vendor:publish --provider="Umbalaconmeogia\LanguageSwitcher\LanguageSwitcherServiceProvider" --tag="language-switcher-assets"

# All assets
php artisan vendor:publish --provider="Umbalaconmeogia\LanguageSwitcher\LanguageSwitcherServiceProvider" --tag="language-switcher"
```

## Usage

### 1. Add routes to your `routes/web.php`:

```php
Route::languageSwitcher();
```

### 2. Add the middleware to your application (optional but recommended):

In your `bootstrap/app.php`:

```php
->withMiddleware(function (Middleware $middleware): void {
    $middleware->web(append: [
        'setlocale',
    ]);
})
```

### 3. Include the language switcher in your views:

Using the Blade component (recommended):
```blade
<x-language-switcher::language-switcher />
```

Or using the include directive (legacy):
```blade
@include('language-switcher::language-switcher')
```

### Component Options

The Blade component supports a `style` attribute for different style variants:
```blade
<!-- Default style - simple dropdown with hover effect -->
<x-language-switcher::language-switcher />

<!-- Minimal style - clean and borderless -->
<x-language-switcher::language-switcher style="minimal" />

<!-- Compact style - smaller padding and font -->
<x-language-switcher::language-switcher style="compact" />
```

**Note**: The language switcher uses a simple, clean design with inline CSS for maximum compatibility. The dropdown appears on hover and works without JavaScript.

### 4. Customize supported languages in `config/language-switcher.php`:

```php
'supported_languages' => [
    'en' => 'English',
    'ja' => '日本語',
    'vi' => 'Tiếng Việt',
    'fr' => 'Français',
],
'default_language' => 'en',
'fallback_language' => 'en',
'session_key' => 'locale',
'detection_method' => 'all', // 'session', 'url', 'header', 'all'
'url_parameter' => 'locale',
'route_prefix' => false,
'cache' => [
    'enabled' => true,
    'ttl' => 3600,
    'prefix' => 'language_switcher_',
],
'component' => [
    'default_style' => 'default',
    'show_flags' => false,
    'show_language_codes' => false,
    'dropdown_position' => 'bottom-right',
    'animation_duration' => 200,
],
'middleware' => [
    'auto_detect' => true,
    'store_in_session' => true,
    'redirect_on_change' => false,
    'exclude_paths' => ['api/*', 'admin/*'],
],
'api' => [
    'enabled' => true,
    'endpoints' => [
        'current' => '/api/languages/current',
        'supported' => '/api/languages/supported',
        'switch' => '/api/languages/{locale}',
    ],
    'response_format' => 'json',
    'include_metadata' => true,
],
'security' => [
    'csrf_protection' => true,
    'allowed_domains' => [],
    'rate_limiting' => [
        'enabled' => false,
        'max_attempts' => 10,
        'decay_minutes' => 1,
    ],
],
```

## Advanced Configuration

### Language Detection Methods

The package supports multiple language detection methods:

- **Session**: Uses stored session preference
- **URL**: Uses URL parameter (e.g., `?locale=en`)
- **Header**: Uses Accept-Language header
- **All**: Uses all methods in order (session → URL → header)

### Middleware Features

- **Path Exclusion**: Skip language detection for specific paths
- **Auto Detection**: Automatic language detection from browser
- **Session Storage**: Store language preference in session
- **Fallback Handling**: Graceful fallback to default language

### Component Configuration

- **Style Variants**: Default, minimal, compact styles
- **Dropdown Position**: Configurable dropdown positioning
- **Animation**: Customizable animation duration
- **Flags Support**: Optional flag display (future feature)

### Security Features

- **CSRF Protection**: Built-in CSRF protection for language switching
- **Rate Limiting**: Configurable rate limiting for API endpoints
- **Domain Restrictions**: Restrict language switching to specific domains

### API Support

- **RESTful Endpoints**: Get current language, supported languages
- **JSON Responses**: Standardized API responses
- **Metadata Inclusion**: Optional metadata in API responses

## Enhanced Features

### Console Commands

The package provides several artisan commands for management:

```bash
# Publish all assets and configuration
php artisan language-switcher:publish

# List supported languages
php artisan language-switcher:list

# List languages in different formats
php artisan language-switcher:list --format=json
php artisan language-switcher:list --format=csv

# Clear language cache
php artisan language-switcher:clear-cache

# Clear cache and session data
php artisan language-switcher:clear-cache --all
```

### API Endpoints

When API is enabled, the package provides RESTful endpoints:

```bash
# Get current language information
GET /api/languages/current

# Get supported languages
GET /api/languages/supported

# Switch language
POST /api/languages/{locale}
```

Example API responses:

```json
// GET /api/languages/current
{
    "current_language": "en",
    "current_language_name": "English",
    "timestamp": "2024-01-15T10:30:00.000000Z",
    "metadata": {
        "detection_method": "all",
        "session_key": "locale",
        "default_language": "en",
        "fallback_language": "en"
    }
}

// GET /api/languages/supported
{
    "languages": [
        {
            "code": "en",
            "name": "English",
            "is_default": true,
            "is_fallback": true
        },
        {
            "code": "ja",
            "name": "日本語",
            "is_default": false,
            "is_fallback": false
        }
    ],
    "count": 2,
    "default_language": "en",
    "fallback_language": "en"
}
```

### Event System

The package fires events when languages are changed:

```php
use Umbalaconmeogia\LanguageSwitcher\Events\LanguageChanged;

// Listen for language changes
Event::listen(LanguageChanged::class, function (LanguageChanged $event) {
    Log::info("Language changed from {$event->previousLanguage} to {$event->newLanguage}");
    
    // Access user information if available
    if ($event->user) {
        Log::info("Changed by user: {$event->user->email}");
    }
});
```

### Conditional Asset Loading

The package automatically loads CSS assets only when needed:
- Assets are not loaded in console commands
- Assets are not loaded for API requests
- Assets can be disabled via configuration

### View Data Sharing

The package automatically shares language data with all views:

```blade
{{-- Available in all views --}}
Current language: {{ $currentLanguage }}
Supported languages: {{ json_encode($supportedLanguages) }}
```

## Language Enum

The package provides a `Language` enum class for easy language management:

```php
use Umbalaconmeogia\LanguageSwitcher\Enums\Language;

// Get supported languages
$languages = Language::getSupportedLanguages();

// Get display name for a language code
$displayName = Language::getDisplayName('ja'); // Returns '日本語'

// Check if language is supported
$isSupported = Language::isSupported('en'); // Returns true

// Get current application locale
$current = Language::getCurrent();

// Get default language
$default = Language::getDefault();

// Check if current language is default
$isDefault = Language::isCurrentDefault();
```

## Middleware

The package includes a `SetLocale` middleware that automatically sets the application locale based on the user's language preference stored in the session. This middleware:

- Reads the locale from the session (set by the language switcher)
- Validates that the locale is supported
- Falls back to the default language if an unsupported locale is detected
- Sets the application locale using `app()->setLocale()`

### Manual Middleware Registration

If you prefer to register the middleware manually, you can add it to your `app/Http/Kernel.php`:

```php
protected $middlewareAliases = [
    // ...
    'setlocale' => \Umbalaconmeogia\LanguageSwitcher\Middleware\SetLocale::class,
];
```

## Customization

- `.language-switcher` - Main container
- `.language-switcher-button` - Button styling
- `.language-switcher-menu` - Dropdown menu
- `.language-switcher-item` - Menu items
- `.language-switcher-item.active` - Active language

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information. 