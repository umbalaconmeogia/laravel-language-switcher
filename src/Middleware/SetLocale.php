<?php

namespace Umbalaconmeogia\LanguageSwitcher\Middleware;

use Umbalaconmeogia\LanguageSwitcher\Enums\Language;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
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
        // Get locale from session, URL parameter, or use default
        $locale = $request->session()->get('locale');
        
        // If no locale in session, check if there's a locale parameter in the request
        if (!$locale) {
            $locale = $request->input('locale');
        }
        
        // If still no locale, check Accept-Language header
        if (!$locale) {
            $locale = $this->getLocaleFromHeader($request);
        }
        
        // Validate the locale is supported, otherwise use default
        if (!$locale || !Language::isSupported($locale)) {
            $locale = Language::getDefault();
        }
        
        // Set the application locale
        App::setLocale($locale);
        
        // Store in session for future requests
        $request->session()->put('locale', $locale);

        return $next($request);
    }

    /**
     * Extract locale from Accept-Language header
     */
    private function getLocaleFromHeader(Request $request): ?string
    {
        $acceptLanguage = $request->header('Accept-Language');
        
        if (!$acceptLanguage) {
            return null;
        }

        // Parse Accept-Language header
        $languages = [];
        foreach (explode(',', $acceptLanguage) as $lang) {
            $parts = explode(';', trim($lang));
            $language = trim($parts[0]);
            $quality = 1.0;
            
            if (isset($parts[1])) {
                $q = explode('=', $parts[1]);
                if (count($q) === 2 && $q[0] === 'q') {
                    $quality = (float) $q[1];
                }
            }
            
            $languages[$language] = $quality;
        }

        // Sort by quality
        arsort($languages);

        // Find the first supported language
        foreach ($languages as $language => $quality) {
            // Extract language code (e.g., 'en-US' -> 'en')
            $code = explode('-', $language)[0];
            
            if (Language::isSupported($code)) {
                return $code;
            }
        }

        return null;
    }
} 