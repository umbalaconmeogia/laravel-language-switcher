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

Publish the configuration file:

```bash
php artisan vendor:publish --provider="Umbalaconmeogia\LanguageSwitcher\LanguageSwitcherServiceProvider" --tag="language-switcher-config"
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

```php
@include('language-switcher::language-switcher')
```

### 4. Customize supported languages in `config/language-switcher.php`:

```php
'supported_languages' => [
    'en' => 'English',
    'ja' => '日本語',
    'vi' => 'Tiếng Việt',
    'fr' => 'Français',
],
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