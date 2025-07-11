<?php

namespace Umbalaconmeogia\LanguageSwitcher\View\Components;

use Illuminate\View\Component;
use Umbalaconmeogia\LanguageSwitcher\Enums\Language;

class LanguageSwitcher extends Component
{
    /**
     * The style variant for the component.
     * @var string
     */
    public string $style;

    /**
     * Create a new component instance.
     *
     * @param string $style
     */
    public function __construct(string $style = 'default')
    {
        $this->style = $style;
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