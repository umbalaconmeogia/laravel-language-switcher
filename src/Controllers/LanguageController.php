<?php

namespace Umbalaconmeogia\LanguageSwitcher\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class LanguageController extends Controller
{
    /**
     * Switch language
     */
    public function switch(Request $request, $locale)
    {
        $supportedLanguages = config('language-switcher.supported_languages', []);
        
        if (array_key_exists($locale, $supportedLanguages)) {
            session(['locale' => $locale]);
            app()->setLocale($locale);
        }
        
        return redirect()->back();
    }
} 