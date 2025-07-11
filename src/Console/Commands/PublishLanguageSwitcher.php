<?php

namespace Umbalaconmeogia\LanguageSwitcher\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;

class PublishLanguageSwitcher extends Command
{
    /**
     * The name and signature of the console command.
     */
    protected $signature = 'language-switcher:publish {--force : Overwrite existing files}';

    /**
     * The console command description.
     */
    protected $description = 'Publish all language switcher assets and configuration files';

    /**
     * Execute the console command.
     */
    public function handle(): int
    {
        $this->info('Publishing Language Switcher assets...');

        $force = $this->option('force');

        // Publish configuration
        $this->info('Publishing configuration...');
        Artisan::call('vendor:publish', [
            '--tag' => 'language-switcher-config',
            '--force' => $force,
        ]);

        // Publish views
        $this->info('Publishing views...');
        Artisan::call('vendor:publish', [
            '--tag' => 'language-switcher-views',
            '--force' => $force,
        ]);

        // Publish assets
        $this->info('Publishing CSS assets...');
        Artisan::call('vendor:publish', [
            '--tag' => 'language-switcher-assets',
            '--force' => $force,
        ]);

        $this->info('Language Switcher assets published successfully!');
        $this->info('Configuration: config/language-switcher.php');
        $this->info('Views: resources/views/vendor/language-switcher/');
        $this->info('CSS: public/vendor/language-switcher/css/');

        return Command::SUCCESS;
    }
} 