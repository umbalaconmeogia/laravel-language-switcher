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

### 2. Include the language switcher in your views:

```php
@include('language-switcher::language-switcher')
```

### 3. Customize supported languages in `config/language-switcher.php`:

```php
'supported_languages' => [
    'en' => 'English',
    'ja' => '日本語',
    'vi' => 'Tiếng Việt',
    'fr' => 'Français',
],
```

## Customization

The package uses simple CSS classes that you can easily override:

- `.language-switcher` - Main container
- `.language-switcher-button` - Button styling
- `.language-switcher-menu` - Dropdown menu
- `.language-switcher-item` - Menu items
- `.language-switcher-item.active` - Active language

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information. 