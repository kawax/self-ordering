<?php

declare(strict_types=1);

namespace Revolution\Ordering\Console;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

class InstallCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'ordering:install {--vercel}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Install the Ordering resources';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle(): int
    {
        File::copy(__DIR__.'/../../stubs/vite.config.js', base_path('vite.config.js'));

        File::ensureDirectoryExists(resource_path('css'));
        File::copy(__DIR__.'/../../stubs/resources/css/app.css', resource_path('css/app.css'));

        File::ensureDirectoryExists(resource_path('js'));
        File::copy(__DIR__.'/../../stubs/resources/js/app.js', resource_path('js/app.js'));
        File::copy(__DIR__.'/../../stubs/package.json', base_path('package.json'));

        // images
        File::ensureDirectoryExists(public_path('images'));
        File::copyDirectory(__DIR__.'/../../stubs/images/', public_path('images'));

        // Listeners
        File::ensureDirectoryExists(app_path('Listeners'));
        File::copyDirectory(__DIR__.'/../../stubs/app/Listeners/', app_path('Listeners'));

        // Vercel
        if ($this->option('vercel')) {
            File::ensureDirectoryExists(base_path('api'));
            File::copyDirectory(__DIR__.'/../../stubs/api/', base_path('api'));
            File::copy(__DIR__.'/../../stubs/.vercelignore', base_path('.vercelignore'));
            File::copy(__DIR__.'/../../stubs/vercel.json', base_path('vercel.json'));
        }

        $this->info('Ordering scaffolding installed successfully.');
        $this->comment('Please execute the "npm install && npm run build" command to build your assets.');

        return 0;
    }
}
