<?php

namespace Umbalaconmeogia\LanguageSwitcher\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Umbalaconmeogia\LanguageSwitcher\Enums\Language;

class LanguageController extends Controller
{
    /**
     * Switch language
     */
    public function switch(Request $request, $locale)
    {
        if (Language::isSupported($locale)) {
            session([config('language-switcher.session_key', 'locale') => $locale]);
            app()->setLocale($locale);
        }
        
        return redirect()->back();
    }
} 