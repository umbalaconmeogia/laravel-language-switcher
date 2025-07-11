<?php

namespace Umbalaconmeogia\LanguageSwitcher\Listeners;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Log;
use Umbalaconmeogia\LanguageSwitcher\Events\LanguageChanged;

class LogLanguageChange implements ShouldQueue
{
    use InteractsWithQueue;

    /**
     * Handle the event.
     */
    public function handle(LanguageChanged $event): void
    {
        // Only log if debug is enabled
        if (!config('language-switcher.debug.log_language_changes', false)) {
            return;
        }

        $userId = $event->user ? $event->user->id : 'guest';
        $userEmail = $event->user ? $event->user->email : 'anonymous';

        Log::info('Language changed', [
            'previous_language' => $event->previousLanguage,
            'new_language' => $event->newLanguage,
            'user_id' => $userId,
            'user_email' => $userEmail,
            'timestamp' => now()->toISOString(),
            'ip_address' => request()->ip(),
            'user_agent' => request()->userAgent(),
        ]);
    }
} 