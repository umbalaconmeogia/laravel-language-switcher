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
        // Get the locale from session (set by language switcher)
        $locale = session(config('language-switcher.session_key', 'locale'), config('app.locale')) ?? config('app.locale');
        
        // Validate that the locale is supported
        if (!Language::isSupported($locale)) {
            $locale = Language::getDefault();
        }
        
        // Set the application locale
        app()->setLocale($locale);
        
        return $next($request);
    }
} 