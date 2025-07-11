# Laravel Language Switcher - Usage Examples

This document provides practical examples of how to use the Laravel Language Switcher package in your applications.

## Basic Usage

### 1. Simple Language Switcher

```blade
<!-- In your layout file -->
<nav>
    <x-language-switcher::language-switcher />
</nav>
```

### 2. Custom Language Switcher

```blade
<!-- Custom language switcher with flags -->
<div class="language-selector">
    @foreach(\Umbalaconmeogia\LanguageSwitcher\Enums\Language::getSupportedLanguages() as $code => $name)
        <a href="{{ route('language.switch', $code) }}" 
           class="language-option {{ app()->getLocale() === $code ? 'active' : '' }}">
            <span class="flag flag-{{ $code }}"></span>
            {{ $name }}
        </a>
    @endforeach
</div>
```

### 3. Language Information in Controllers

```php
<?php

namespace App\Http\Controllers;

use Umbalaconmeogia\LanguageSwitcher\Enums\Language;

class DashboardController extends Controller
{
    public function index()
    {
        $currentLanguage = Language::getCurrent();
        $currentDisplayName = Language::getDisplayName($currentLanguage);
        $isDefaultLanguage = Language::isCurrentDefault();
        
        return view('dashboard', compact('currentLanguage', 'currentDisplayName', 'isDefaultLanguage'));
    }
}
```

## Advanced Usage

### 1. Conditional Content Based on Language

```blade
@if(\Umbalaconmeogia\LanguageSwitcher\Enums\Language::getCurrent() === 'ja')
    <div class="japanese-content">
        <!-- Japanese specific content -->
    </div>
@elseif(\Umbalaconmeogia\LanguageSwitcher\Enums\Language::getCurrent() === 'vi')
    <div class="vietnamese-content">
        <!-- Vietnamese specific content -->
    </div>
@else
    <div class="english-content">
        <!-- English content -->
    </div>
@endif
```

### 2. Language-Specific Routes

```php
// In routes/web.php
Route::get('/about', function () {
    $language = \Umbalaconmeogia\LanguageSwitcher\Enums\Language::getCurrent();
    
    if ($language === 'ja') {
        return view('about.japanese');
    } elseif ($language === 'vi') {
        return view('about.vietnamese');
    }
    
    return view('about.english');
})->name('about');
```

### 3. API Endpoints for Language Information

```php
// In routes/api.php
Route::get('/languages', function () {
    return response()->json([
        'current' => \Umbalaconmeogia\LanguageSwitcher\Enums\Language::getCurrent(),
        'supported' => \Umbalaconmeogia\LanguageSwitcher\Enums\Language::getSupportedLanguages(),
        'default' => \Umbalaconmeogia\LanguageSwitcher\Enums\Language::getDefault(),
    ]);
});

Route::post('/languages/{locale}', function ($locale) {
    if (!\Umbalaconmeogia\LanguageSwitcher\Enums\Language::isSupported($locale)) {
        return response()->json(['error' => 'Unsupported language'], 400);
    }
    
    session(['locale' => $locale]);
    app()->setLocale($locale);
    
    return response()->json(['success' => true, 'locale' => $locale]);
});
```

### 4. Language Detection in Middleware

```php
<?php

namespace App\Http\Middleware;

use Umbalaconmeogia\LanguageSwitcher\Enums\Language;
use Closure;
use Illuminate\Http\Request;

class CustomLanguageMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        // Check if user has a preferred language in their profile
        if (auth()->check() && auth()->user()->preferred_language) {
            $userLanguage = auth()->user()->preferred_language;
            
            if (Language::isSupported($userLanguage)) {
                app()->setLocale($userLanguage);
                session(['locale' => $userLanguage]);
            }
        }
        
        return $next($request);
    }
}
```

### 5. Language-Specific Validation Messages

```php
<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Umbalaconmeogia\LanguageSwitcher\Enums\Language;

class UserRegistrationRequest extends FormRequest
{
    public function rules()
    {
        return [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:8',
        ];
    }

    public function messages()
    {
        $language = Language::getCurrent();
        
        if ($language === 'ja') {
            return [
                'name.required' => '名前は必須です。',
                'email.required' => 'メールアドレスは必須です。',
                'email.email' => '有効なメールアドレスを入力してください。',
                'password.required' => 'パスワードは必須です。',
                'password.min' => 'パスワードは8文字以上で入力してください。',
            ];
        }
        
        return parent::messages();
    }
}
```

### 6. Language-Specific Database Queries

```php
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Umbalaconmeogia\LanguageSwitcher\Enums\Language;

class Article extends Model
{
    public function scopeInCurrentLanguage($query)
    {
        $language = Language::getCurrent();
        
        return $query->where('language', $language);
    }
    
    public function scopeInLanguage($query, $language)
    {
        if (Language::isSupported($language)) {
            return $query->where('language', $language);
        }
        
        return $query->where('language', Language::getDefault());
    }
}

// Usage
$articles = Article::inCurrentLanguage()->get();
$japaneseArticles = Article::inLanguage('ja')->get();
```

### 7. Language-Specific Email Templates

```php
<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Umbalaconmeogia\LanguageSwitcher\Enums\Language;

class WelcomeEmail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(public $user)
    {
        //
    }

    public function build()
    {
        $language = Language::getCurrent();
        
        return $this->view("emails.welcome.{$language}")
                    ->subject($this->getSubject($language));
    }
    
    private function getSubject($language)
    {
        return match($language) {
            'ja' => 'ようこそ！',
            'vi' => 'Chào mừng!',
            default => 'Welcome!',
        };
    }
}
```

### 8. Language-Specific Configuration

```php
// In config/app.php
'locale' => \Umbalaconmeogia\LanguageSwitcher\Enums\Language::getCurrent(),

// In config/services.php
'mailgun' => [
    'domain' => env('MAILGUN_DOMAIN'),
    'secret' => env('MAILGUN_SECRET'),
    'endpoint' => env('MAILGUN_ENDPOINT', 'api.mailgun.net'),
    'scheme' => 'https',
    'locale' => \Umbalaconmeogia\LanguageSwitcher\Enums\Language::getCurrent(),
],
```

### 9. Language-Specific Cache Keys

```php
<?php

namespace App\Services;

use Umbalaconmeogia\LanguageSwitcher\Enums\Language;
use Illuminate\Support\Facades\Cache;

class ContentService
{
    public function getCachedContent($key)
    {
        $language = Language::getCurrent();
        $cacheKey = "content_{$language}_{$key}";
        
        return Cache::remember($cacheKey, 3600, function () use ($key) {
            return $this->fetchContent($key);
        });
    }
}
```

### 10. Language-Specific File Paths

```php
<?php

namespace App\Services;

use Umbalaconmeogia\LanguageSwitcher\Enums\Language;

class FileService
{
    public function getLanguageSpecificPath($basePath)
    {
        $language = Language::getCurrent();
        return "{$basePath}/{$language}";
    }
    
    public function getLanguageSpecificAsset($asset)
    {
        $language = Language::getCurrent();
        return asset("assets/{$language}/{$asset}");
    }
}
```

## Integration Examples

### 1. With Laravel Breeze/Jetstream

```blade
<!-- In resources/views/navigation-menu.blade.php -->
<div class="hidden space-x-8 sm:-my-px sm:ml-10 sm:flex">
    <x-nav-link href="{{ route('dashboard') }}" :active="request()->routeIs('dashboard')">
        {{ __('Dashboard') }}
    </x-nav-link>
    
    <!-- Add language switcher to navigation -->
    <div class="flex items-center">
        <x-language-switcher::language-switcher />
    </div>
</div>
```

### 2. With Admin Panels

```blade
<!-- In admin layout -->
<div class="admin-header">
    <div class="admin-nav">
        <a href="{{ route('admin.dashboard') }}">Dashboard</a>
        <a href="{{ route('admin.users') }}">Users</a>
        <a href="{{ route('admin.settings') }}">Settings</a>
    </div>
    
    <div class="admin-actions">
        <x-language-switcher::language-switcher />
        <div class="user-menu">
            <!-- User menu items -->
        </div>
    </div>
</div>
```

### 3. With Mobile Applications

```blade
<!-- Mobile-friendly language switcher -->
<div class="mobile-language-switcher">
    <x-language-switcher::language-switcher />
</div>

<style>
.mobile-language-switcher {
    position: fixed;
    bottom: 20px;
    right: 20px;
    z-index: 1000;
}

.mobile-language-switcher .language-switcher {
    background: rgba(0, 0, 0, 0.8);
    border-radius: 50%;
    padding: 15px;
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.3);
}
</style>
```

## Best Practices

### 1. Always Use the Language Enum

```php
// Good
use Umbalaconmeogia\LanguageSwitcher\Enums\Language;
$currentLanguage = Language::getCurrent();

// Avoid
$currentLanguage = app()->getLocale();
```

### 2. Validate Language Codes

```php
// Always validate before using
if (Language::isSupported($requestedLanguage)) {
    app()->setLocale($requestedLanguage);
} else {
    app()->setLocale(Language::getDefault());
}
```

### 3. Use Language-Specific Caching

```php
// Include language in cache keys
$cacheKey = "data_{$language}_{$id}";
```

### 4. Provide Fallbacks

```php
// Always provide fallback content
$content = $this->getContent($language) ?? $this->getContent(Language::getDefault());
```

This comprehensive guide should help you implement the language switcher in various scenarios and follow best practices for multilingual applications. 