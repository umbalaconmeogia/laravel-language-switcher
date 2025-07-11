<?php

namespace Umbalaconmeogia\LanguageSwitcher\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SetLocale
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Get the locale from session (set by language switcher)
        $locale = session(config('language-switcher.session_key', 'locale'), config('app.locale'));
        
        // Validate that the locale is supported
        $supportedLanguages = config('language-switcher.supported_languages', []);
        if (!array_key_exists($locale, $supportedLanguages)) {
            $locale = config('language-switcher.default_language', config('app.locale'));
        }
        
        // Set the application locale
        app()->setLocale($locale);
        
        return $next($request);
    }
} 