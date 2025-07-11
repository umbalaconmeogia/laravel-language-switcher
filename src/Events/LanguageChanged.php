<?php

namespace Umbalaconmeogia\LanguageSwitcher\Events;

use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class LanguageChanged
{
    use Dispatchable, SerializesModels;

    /**
     * The previous language
     */
    public string $previousLanguage;

    /**
     * The new language
     */
    public string $newLanguage;

    /**
     * The user who changed the language (if authenticated)
     */
    public $user;

    /**
     * Create a new event instance.
     */
    public function __construct(string $previousLanguage, string $newLanguage, $user = null)
    {
        $this->previousLanguage = $previousLanguage;
        $this->newLanguage = $newLanguage;
        $this->user = $user;
    }
} 