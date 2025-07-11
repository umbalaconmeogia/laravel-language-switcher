<?php

namespace Umbalaconmeogia\LanguageSwitcher\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Session;

class ClearLanguageCache extends Command
{
    /**
     * The name and signature of the console command.
     */
    protected $signature = 'language-switcher:clear-cache {--all : Clear all cache including session}';

    /**
     * The console command description.
     */
    protected $description = 'Clear language switcher cache and session data';

    /**
     * Execute the console command.
     */
    public function handle(): int
    {
        $clearAll = $this->option('all');
        $cachePrefix = config('language-switcher.cache.prefix', 'language_switcher_');

        $this->info('Clearing Language Switcher cache...');

        // Clear cache
        $cacheCleared = false;
        if (config('language-switcher.cache.enabled', true)) {
            // Get all cache keys with the prefix
            $keys = Cache::get('language_switcher_cache_keys', []);
            
            foreach ($keys as $key) {
                Cache::forget($key);
            }
            
            // Clear the keys list itself
            Cache::forget('language_switcher_cache_keys');
            
            $cacheCleared = true;
            $this->info('✓ Cache cleared');
        }

        // Clear session data if requested
        if ($clearAll) {
            $sessionKey = config('language-switcher.session_key', 'locale');
            
            // Note: In console, we can't directly clear session
            // But we can provide instructions
            $this->info('✓ Session clear instructions provided');
            $this->line("To clear session data, run: php artisan session:clear");
            $this->line("Or manually remove the '{$sessionKey}' key from session storage");
        }

        if ($cacheCleared || $clearAll) {
            $this->info('Language Switcher cache cleared successfully!');
        } else {
            $this->warn('No cache to clear (caching is disabled)');
        }

        return Command::SUCCESS;
    }
} 