<?php

namespace Umbalaconmeogia\LanguageSwitcher\Console\Commands;

use Illuminate\Console\Command;
use Umbalaconmeogia\LanguageSwitcher\Enums\Language;

class ListSupportedLanguages extends Command
{
    /**
     * The name and signature of the console command.
     */
    protected $signature = 'language-switcher:list {--format=table : Output format (table, json, csv)}';

    /**
     * The console command description.
     */
    protected $description = 'List all supported languages and their configuration';

    /**
     * Execute the console command.
     */
    public function handle(): int
    {
        $format = $this->option('format');
        $supportedLanguages = config('language-switcher.supported_languages', []);
        $defaultLanguage = config('language-switcher.default_language', 'en');
        $fallbackLanguage = config('language-switcher.fallback_language', 'en');

        $this->info('Language Switcher Configuration');
        $this->info('==============================');
        $this->info("Default Language: {$defaultLanguage}");
        $this->info("Fallback Language: {$fallbackLanguage}");
        $this->info('');

        if (empty($supportedLanguages)) {
            $this->warn('No supported languages configured.');
            return Command::SUCCESS;
        }

        switch ($format) {
            case 'json':
                $this->line(json_encode($supportedLanguages, JSON_PRETTY_PRINT));
                break;
            case 'csv':
                $this->line("Code,Name");
                foreach ($supportedLanguages as $code => $name) {
                    $this->line("{$code},{$name}");
                }
                break;
            default:
                $this->table(
                    ['Code', 'Name', 'Is Default', 'Is Fallback'],
                    collect($supportedLanguages)->map(function ($name, $code) use ($defaultLanguage, $fallbackLanguage) {
                        return [
                            $code,
                            $name,
                            $code === $defaultLanguage ? '✓' : '',
                            $code === $fallbackLanguage ? '✓' : '',
                        ];
                    })->toArray()
                );
        }

        return Command::SUCCESS;
    }
} 