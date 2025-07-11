<?php

namespace Umbalaconmeogia\LanguageSwitcher\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Umbalaconmeogia\LanguageSwitcher\Enums\Language;
use Umbalaconmeogia\LanguageSwitcher\Events\LanguageChanged;

class LanguageController extends Controller
{
    /**
     * Switch language
     */
    public function switch(Request $request, $locale)
    {
        if (Language::isSupported($locale)) {
            $previousLanguage = app()->getLocale();
            $sessionKey = config('language-switcher.session_key', 'locale');
            
            session([$sessionKey => $locale]);
            app()->setLocale($locale);
            
            // Fire event
            event(new LanguageChanged($previousLanguage, $locale, $request->user()));
        }
        
        return redirect()->back();
    }
} 