<?php

namespace Umbalaconmeogia\LanguageSwitcher\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Umbalaconmeogia\LanguageSwitcher\Enums\Language;

class SetLocale
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Check if middleware should be skipped for this path
        if ($this->shouldSkipMiddleware($request)) {
            return $next($request);
        }

        // Detect language based on configuration
        $locale = $this->detectLanguage($request);
        
        // Validate that the locale is supported
        if (!Language::isSupported($locale)) {
            $locale = Language::getFallback();
        }
        
        // Set the application locale
        app()->setLocale($locale);
        
        // Store in session if enabled
        if (config('language-switcher.middleware.store_in_session', true)) {
            session([config('language-switcher.session_key', 'locale') => $locale]);
        }
        
        return $next($request);
    }

    /**
     * Check if middleware should be skipped for this request
     */
    private function shouldSkipMiddleware(Request $request): bool
    {
        $excludePaths = config('language-switcher.middleware.exclude_paths', []);
        
        foreach ($excludePaths as $pattern) {
            if ($request->is($pattern)) {
                return true;
            }
        }
        
        return false;
    }

    /**
     * Detect language using configured detection method
     */
    private function detectLanguage(Request $request): string
    {
        $detectionMethod = Language::getDetectionMethod();
        
        switch ($detectionMethod) {
            case 'session':
                return $this->detectFromSession();
                
            case 'url':
                return $this->detectFromUrl($request);
                
            case 'header':
                return $this->detectFromHeader($request);
                
            case 'all':
            default:
                return $this->detectFromAll($request);
        }
    }

    /**
     * Detect language from session
     */
    private function detectFromSession(): string
    {
        return session(config('language-switcher.session_key', 'locale'), config('app.locale')) ?? config('app.locale');
    }

    /**
     * Detect language from URL parameter
     */
    private function detectFromUrl(Request $request): string
    {
        $parameter = Language::getUrlParameter();
        return $request->get($parameter, config('app.locale'));
    }

    /**
     * Detect language from Accept-Language header
     */
    private function detectFromHeader(Request $request): string
    {
        $acceptLanguage = $request->header('Accept-Language');
        
        if (!$acceptLanguage) {
            return config('app.locale');
        }
        
        // Parse Accept-Language header
        $languages = explode(',', $acceptLanguage);
        $firstLanguage = trim(explode(';', $languages[0])[0]);
        
        // Extract language code (e.g., 'en-US' -> 'en')
        $languageCode = substr($firstLanguage, 0, 2);
        
        return Language::isSupported($languageCode) ? $languageCode : config('app.locale');
    }

    /**
     * Detect language using all methods in order
     */
    private function detectFromAll(Request $request): string
    {
        // 1. Try session first
        $sessionLocale = $this->detectFromSession();
        if (Language::isSupported($sessionLocale)) {
            return $sessionLocale;
        }
        
        // 2. Try URL parameter
        $urlLocale = $this->detectFromUrl($request);
        if (Language::isSupported($urlLocale)) {
            return $urlLocale;
        }
        
        // 3. Try header
        $headerLocale = $this->detectFromHeader($request);
        if (Language::isSupported($headerLocale)) {
            return $headerLocale;
        }
        
        // 4. Fallback to default
        return config('app.locale');
    }
} 