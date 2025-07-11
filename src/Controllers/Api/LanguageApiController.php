<?php

namespace Umbalaconmeogia\LanguageSwitcher\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Http\JsonResponse;
use Umbalaconmeogia\LanguageSwitcher\Enums\Language;
use Umbalaconmeogia\LanguageSwitcher\Events\LanguageChanged;

class LanguageApiController extends Controller
{
    /**
     * Get current language information
     */
    public function current(Request $request): JsonResponse
    {
        $currentLocale = app()->getLocale();
        $supportedLanguages = config('language-switcher.supported_languages', []);
        
        $response = [
            'current_language' => $currentLocale,
            'current_language_name' => $supportedLanguages[$currentLocale] ?? $currentLocale,
            'timestamp' => now()->toISOString(),
        ];

        // Include metadata if enabled
        if (config('language-switcher.api.include_metadata', true)) {
            $response['metadata'] = [
                'detection_method' => config('language-switcher.detection_method', 'all'),
                'session_key' => config('language-switcher.session_key', 'locale'),
                'default_language' => config('language-switcher.default_language', 'en'),
                'fallback_language' => config('language-switcher.fallback_language', 'en'),
            ];
        }

        return response()->json($response);
    }

    /**
     * Get supported languages
     */
    public function supported(Request $request): JsonResponse
    {
        $supportedLanguages = config('language-switcher.supported_languages', []);
        $defaultLanguage = config('language-switcher.default_language', 'en');
        $fallbackLanguage = config('language-switcher.fallback_language', 'en');
        
        $languages = collect($supportedLanguages)->map(function ($name, $code) use ($defaultLanguage, $fallbackLanguage) {
            return [
                'code' => $code,
                'name' => $name,
                'is_default' => $code === $defaultLanguage,
                'is_fallback' => $code === $fallbackLanguage,
            ];
        })->values();

        $response = [
            'languages' => $languages,
            'count' => count($supportedLanguages),
            'default_language' => $defaultLanguage,
            'fallback_language' => $fallbackLanguage,
        ];

        // Include metadata if enabled
        if (config('language-switcher.api.include_metadata', true)) {
            $response['metadata'] = [
                'cache_enabled' => config('language-switcher.cache.enabled', true),
                'cache_ttl' => config('language-switcher.cache.ttl', 3600),
            ];
        }

        return response()->json($response);
    }

    /**
     * Switch language via API
     */
    public function switch(Request $request, string $locale): JsonResponse
    {
        // Validate locale
        if (!Language::isSupported($locale)) {
            return response()->json([
                'error' => 'Unsupported language',
                'message' => "Language '{$locale}' is not supported",
                'supported_languages' => array_keys(config('language-switcher.supported_languages', [])),
            ], 400);
        }

        // Check rate limiting if enabled
        if (config('language-switcher.security.rate_limiting.enabled', false)) {
            $this->checkRateLimit($request);
        }

        $previousLanguage = app()->getLocale();
        $sessionKey = config('language-switcher.session_key', 'locale');

        // Set the new language
        session([$sessionKey => $locale]);
        app()->setLocale($locale);

        // Fire event
        event(new LanguageChanged($previousLanguage, $locale, $request->user()));

        $response = [
            'success' => true,
            'previous_language' => $previousLanguage,
            'new_language' => $locale,
            'message' => "Language switched to {$locale}",
            'timestamp' => now()->toISOString(),
        ];

        // Include redirect URL if requested
        if ($request->has('redirect_url')) {
            $response['redirect_url'] = $request->get('redirect_url');
        }

        return response()->json($response);
    }

    /**
     * Check rate limiting for language switching
     */
    private function checkRateLimit(Request $request): void
    {
        $maxAttempts = config('language-switcher.security.rate_limiting.max_attempts', 10);
        $decayMinutes = config('language-switcher.security.rate_limiting.decay_minutes', 1);

        $key = 'language_switch_' . $request->ip();
        
        if (cache()->has($key) && cache()->get($key) >= $maxAttempts) {
            abort(429, 'Too many language switch attempts. Please try again later.');
        }

        cache()->increment($key, 1, now()->addMinutes($decayMinutes));
    }
} 