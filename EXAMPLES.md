# Laravel Multilingual Package - Usage Examples

This document provides practical examples of how to use the Laravel Multilingual package in your applications.

## Basic Usage

### 1. Simple Language Switcher

```blade
<!-- In your layout file -->
<nav>
    <x-multilingual::language-switcher />
</nav>
```

### 2. Custom Language Switcher

```blade
<!-- Custom language switcher with flags -->
<div class="language-selector">
    @foreach(\App\Packages\LaravelMultilingual\Enums\Language::getSupportedLanguages() as $code => $name)
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

use App\Packages\LaravelMultilingual\Enums\Language;

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
@if(\App\Packages\LaravelMultilingual\Enums\Language::getCurrent() === 'ja')
    <div class="japanese-content">
        <!-- Japanese specific content -->
    </div>
@elseif(\App\Packages\LaravelMultilingual\Enums\Language::getCurrent() === 'vi')
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
    $language = \App\Packages\LaravelMultilingual\Enums\Language::getCurrent();
    
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
        'current' => \App\Packages\LaravelMultilingual\Enums\Language::getCurrent(),
        'supported' => \App\Packages\LaravelMultilingual\Enums\Language::getSupportedLanguages(),
        'default' => \App\Packages\LaravelMultilingual\Enums\Language::getDefault(),
    ]);
});

Route::post('/languages/{locale}', function ($locale) {
    if (!\App\Packages\LaravelMultilingual\Enums\Language::isSupported($locale)) {
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

use App\Packages\LaravelMultilingual\Enums\Language;
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
use App\Packages\LaravelMultilingual\Enums\Language;

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
use App\Packages\LaravelMultilingual\Enums\Language;

class Article extends Model
{
    public function scopeInCurrentLanguage($query)
    {
        $language = Language::getCurrent();
        
        return $query->where('language', $language)
                    ->orWhere('language', Language::getFallback());
    }
    
    public function scopeInLanguage($query, $language)
    {
        if (!Language::isSupported($language)) {
            $language = Language::getDefault();
        }
        
        return $query->where('language', $language);
    }
}

// Usage in controller
$articles = Article::inCurrentLanguage()->get();
$japaneseArticles = Article::inLanguage('ja')->get();
```

### 7. Language Switcher with AJAX

```javascript
// In your JavaScript file
function switchLanguage(locale) {
    fetch(`/language/${locale}`, {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
            'Content-Type': 'application/json',
        },
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            window.location.reload();
        }
    })
    .catch(error => {
        console.error('Error switching language:', error);
    });
}
```

```blade
<!-- In your view -->
<div class="language-buttons">
    @foreach(\App\Packages\LaravelMultilingual\Enums\Language::getSupportedLanguages() as $code => $name)
        <button onclick="switchLanguage('{{ $code }}')" 
                class="lang-btn {{ app()->getLocale() === $code ? 'active' : '' }}">
            {{ $name }}
        </button>
    @endforeach
</div>
```

### 8. Language-Specific Email Templates

```php
<?php

namespace App\Mail;

use Illuminate\Mail\Mailable;
use App\Packages\LaravelMultilingual\Enums\Language;

class WelcomeEmail extends Mailable
{
    public function __construct(public $user)
    {
        $this->locale = Language::getCurrent();
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
            'ja' => 'アカウント登録完了のお知らせ',
            'vi' => 'Thông báo đăng ký tài khoản thành công',
            default => 'Welcome to our platform!',
        };
    }
}
```

## Configuration Examples

### 1. Custom Language Configuration

```php
// In config/multilingual.php
return [
    'supported_languages' => [
        'en' => 'English',
        'ja' => '日本語',
        'vi' => 'Tiếng Việt',
        'fr' => 'Français',
        'de' => 'Deutsch',
    ],
    'default_language' => 'en',
    'fallback_language' => 'en',
    'detection_method' => 'all',
    'switcher' => [
        'show_current' => true,
        'show_flags' => true,
        'dropdown_style' => 'minimal',
        'mobile_friendly' => true,
    ],
];
```

### 2. Environment-Specific Configuration

```php
// In config/multilingual.php
return [
    'supported_languages' => [
        'en' => 'English',
        'ja' => '日本語',
        'vi' => 'Tiếng Việt',
    ],
    'default_language' => env('DEFAULT_LANGUAGE', 'ja'),
    'fallback_language' => env('FALLBACK_LANGUAGE', 'en'),
    'cache' => [
        'enabled' => env('LANGUAGE_CACHE_ENABLED', true),
        'ttl' => env('LANGUAGE_CACHE_TTL', 3600),
    ],
];
```

## Testing Examples

### 1. Testing Language Switching

```php
<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Packages\LaravelMultilingual\Enums\Language;

class LanguageTest extends TestCase
{
    public function test_user_can_switch_language()
    {
        $response = $this->post('/language/en');
        
        $response->assertRedirect();
        $this->assertEquals('en', session('locale'));
    }
    
    public function test_invalid_language_returns_error()
    {
        $response = $this->post('/language/invalid');
        
        $response->assertRedirect();
        $response->assertSessionHasErrors('language');
    }
    
    public function test_language_persists_across_requests()
    {
        $this->post('/language/vi');
        $this->assertEquals('vi', session('locale'));
        
        $response = $this->get('/dashboard');
        $this->assertEquals('vi', app()->getLocale());
    }
}
```

These examples demonstrate the flexibility and power of the Laravel Multilingual package. You can adapt these patterns to fit your specific application needs. 