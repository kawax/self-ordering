<?php

namespace Revolution\Ordering\Console;

use Illuminate\Console\Command;
use Illuminate\Filesystem\Filesystem;

/**
 * @codeCoverageIgnore
 */
class InstallCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'ordering:install';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Install the Ordering resources';

    /**
     * Execute the console command.
     *
     * @return void
     */
    public function handle()
    {
        copy(__DIR__.'/../../stubs/tailwind.config.js', base_path('tailwind.config.js'));
        copy(__DIR__.'/../../stubs/webpack.mix.js', base_path('webpack.mix.js'));
        copy(__DIR__.'/../../stubs/resources/css/app.css', resource_path('css/app.css'));
        copy(__DIR__.'/../../stubs/resources/js/app.js', resource_path('js/app.js'));
        copy(__DIR__.'/../../stubs/package.json', base_path('package.json'));

        // images
        (new Filesystem())->ensureDirectoryExists(public_path('images'));
        (new Filesystem())->copyDirectory(__DIR__.'/../../stubs/images/', public_path('images'));

        // Listeners
        (new Filesystem())->ensureDirectoryExists(app_path('Listeners'));
        (new Filesystem())->copyDirectory(__DIR__.'/../../stubs/app/Listeners/', app_path('Listeners'));

        copy(__DIR__.'/../../stubs/app/Providers/EventServiceProvider.php',
            app_path('Providers/EventServiceProvider.php'));

        // Vercel
        (new Filesystem())->ensureDirectoryExists(base_path('api'));
        (new Filesystem())->copyDirectory(__DIR__.'/../../stubs/api/', base_path('api'));
        copy(__DIR__.'/../../stubs/.vercelignore', base_path('.vercelignore'));
        copy(__DIR__.'/../../stubs/vercel.json', base_path('vercel.json'));


        $this->info('Ordering scaffolding installed successfully.');
        $this->comment('Please execute the "npm install && npm run dev" command to build your assets.');
    }

    /**
     * Replace a given string within a given file.
     *
     * @param  string  $search
     * @param  string  $replace
     * @param  string  $path
     *
     * @return void
     */
    protected function replaceInFile($search, $replace, $path)
    {
        file_put_contents($path, str_replace($search, $replace, file_get_contents($path)));
    }
}
