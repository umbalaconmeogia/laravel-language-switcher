# Laravel Language Switcher Package

A reusable Laravel package for implementing multilingual functionality in Laravel applications.

## Features

- **Language Management**: Easy configuration of supported languages
- **Language Switching**: Seamless language switching with session persistence
- **Middleware Integration**: Automatic locale setting for each request
- **UI Components**: Ready-to-use Blade components for language switcher
- **CSS Independent**: No dependency on specific CSS frameworks
- **Flexible Configuration**: Easy to customize for different applications

## Installation

1. Install the package via Composer:
```bash
composer require umbalaconmeogia/laravel-language-switcher
```
2. Add the service provider to your `config/app.php`:

```php
'providers' => [
    // ...
    Umbalaconmeogia\LanguageSwitcher\LanguageSwitcherServiceProvider::class,
],
```

3. Publish the configuration file:
```bash
php artisan vendor:publish --provider="Umbalaconmeogia\LanguageSwitcher\LanguageSwitcherServiceProvider"
```

4. Add the middleware to your `bootstrap/app.php`:
```php
$middleware->alias([
    'setlocale' => \Umbalaconmeogia\LanguageSwitcher\Middleware\SetLocale::class,
]);

$middleware->web(append: [
    \Umbalaconmeogia\LanguageSwitcher\Middleware\SetLocale::class,
]);
```

5. Add the routes to your `routes/web.php`:
```php
Route::post('/language-switcher/{locale}', [\Umbalaconmeogia\LanguageSwitcher\Controllers\LanguageController::class, 'switch'])->name('language.switch');
```

6. (Optional) Publish the CSS file for styling:
```bash
php artisan vendor:publish --provider="Umbalaconmeogia\LanguageSwitcher\LanguageSwitcherServiceProvider" --tag=language-switcher-css
```

## Configuration

Edit `config/language-switcher.php` to customize the package:

```php
return [
    'supported_languages' => [
        'en' => 'English',
        'ja' => '日本語',
        'vi' => 'Tiếng Việt',
    ],
    'default_language' => 'ja',
    'fallback_language' => 'en',
];
```

## Usage

### In Views

Use the language switcher component:

```blade
<!-- Default style -->
<x-language-switcher::language-switcher />

<!-- Minimal style -->
<x-language-switcher::language-switcher style="minimal" />

<!-- Compact style -->
<x-language-switcher::language-switcher style="compact" />
```

### In Controllers

Access current language:

```php
use Umbalaconmeogia\LanguageSwitcher\Enums\Language;

$currentLanguage = app()->getLocale();
$displayName = Language::getDisplayName($currentLanguage);
```

### Custom Language Switcher

Create your own language switcher using the Language enum:

```blade
@foreach(\Umbalaconmeogia\LanguageSwitcher\Enums\Language::getSupportedLanguages() as $code => $name)
    <a href="{{ route('language.switch', $code) }}">{{ $name }}</a>
@endforeach
```

## API Reference

### Language Enum

- `Language::SUPPORTED_LANGUAGES` - Array of supported languages
- `Language::getDisplayName(string $code)` - Get display name for language code
- `Language::isSupported(string $code)` - Check if language is supported
- `Language::getDefault()` - Get default language code

### LanguageController

- `switch(Request $request, string $locale)` - Switch application language

### SetLocale Middleware

Automatically sets the application locale based on session or request parameters.

## Customization

### Adding New Languages

1. Update the configuration file
2. Add translation files in `resources/lang/`
3. Update the Language enum if needed

### Custom Styling

The package uses semantic CSS classes that are independent of any CSS framework. You can:

1. **Use the provided CSS** (recommended):
```bash
php artisan vendor:publish --provider="Umbalaconmeogia\LanguageSwitcher\LanguageSwitcherServiceProvider" --tag=language-switcher-css
```

2. **Override the component views** by publishing them:
```bash
php artisan vendor:publish --provider="Umbalaconmeogia\LanguageSwitcher\LanguageSwitcherServiceProvider" --tag=language-switcher-views
```

3. **Use your own CSS** by targeting the semantic classes:
   - `.multilingual-language-switcher` - Main container
   - `.multilingual-trigger` - Trigger button
   - `.multilingual-current` - Current language text
   - `.multilingual-arrow` - Dropdown arrow
   - `.multilingual-option` - Language option buttons

## License

This package is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT). 