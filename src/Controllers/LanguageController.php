<?php

namespace Umbalaconmeogia\LanguageSwitcher\Controllers;

use Umbalaconmeogia\LanguageSwitcher\Enums\Language;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Routing\Controller;

class LanguageController extends Controller
{
    /**
     * Switch the application language and redirect back
     */
    public function switch(Request $request, string $locale): RedirectResponse
    {
        // Validate the locale is supported
        if (!Language::isSupported($locale)) {
            return redirect()->back()->withErrors([
                'language' => __('language-switcher::language-switcher.unsupported_language')
            ]);
        }

        // Store the locale in session
        $request->session()->put('locale', $locale);

        // Set the application locale immediately
        app()->setLocale($locale);

        return redirect()->back()->with('success', __('language-switcher::language-switcher.language_changed'));
    }

    /**
     * Get current language information
     */
    public function current(): array
    {
        return [
            'current' => Language::getCurrent(),
            'default' => Language::getDefault(),
            'supported' => Language::getSupportedLanguages(),
            'is_default' => Language::isCurrentDefault(),
        ];
    }

    /**
     * Get all supported languages
     */
    public function supported(): array
    {
        return [
            'languages' => Language::getSupportedLanguages(),
            'codes' => Language::getSupportedCodes(),
        ];
    }
} 