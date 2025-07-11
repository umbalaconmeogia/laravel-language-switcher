<?php

namespace Umbalaconmeogia\LanguageSwitcher\View\Components;

use Umbalaconmeogia\LanguageSwitcher\Enums\Language;
use Illuminate\View\Component;

class LanguageSwitcher extends Component
{
    /**
     * Create a new component instance.
     */
    public function __construct(
        public string $style = 'default'
    ) {
        //
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render()
    {
        return view('language-switcher::language-switcher');
    }

    /**
     * Get the data that should be supplied to the view.
     */
    public function data(): array
    {
        return [
            'currentLanguage' => Language::getCurrent(),
            'currentDisplayName' => Language::getDisplayName(Language::getCurrent()),
            'supportedLanguages' => Language::getSupportedLanguages(),
            'isDefault' => Language::isCurrentDefault(),
            'style' => $this->style,
        ];
    }
} 