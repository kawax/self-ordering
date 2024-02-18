<?php

declare(strict_types=1);

namespace Revolution\Ordering\Providers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\ServiceProvider;
use Revolution\Ordering\Console\InstallCommand;
use Revolution\Ordering\Contracts\Auth\OrderingGuard;
use Revolution\Ordering\Providers\Concerns\WithBindings;
use Revolution\Ordering\Providers\Concerns\WithGoogleSheets;
use Revolution\Ordering\Providers\Concerns\WithLivewire;
use Revolution\Ordering\Providers\Concerns\WithRoutes;
use Revolution\Ordering\View\Components\AppLayout;
use Revolution\Ordering\View\Components\DashboardLayout;

class OrderingServiceProvider extends ServiceProvider
{
    use WithBindings;
    use WithGoogleSheets;
    use WithLivewire;
    use WithRoutes;

    public function register(): void
    {
        $this->registerBindings();

        $this->registerGoogle();

        $this->registerLivewire();

        config([
            'auth.guards.ordering' => array_merge([
                'driver' => 'ordering',
                'provider' => null,
            ], config('auth.guards.ordering', [])),
        ]);

        if (! $this->app->configurationIsCached()) {
            $this->mergeConfigFrom(__DIR__.'/../../config/ordering.php', 'ordering');
        }
    }

    public function boot(): void
    {
        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__.'/../../config/ordering.php' => config_path('ordering.php'),
            ], 'ordering-config');

            $this->publishes([
                __DIR__.'/../../resources/views' => resource_path('views/vendor/ordering'),
            ], 'ordering-views');

            $this->commands([
                InstallCommand::class,
            ]);
        }

        $this->configureView();

        $this->configureAuth();

        $this->configureRoutes();
    }

    protected function configureView(): void
    {
        $this->loadViewsFrom(__DIR__.'/../../resources/views', 'ordering');

        $this->loadViewComponentsAs('ordering', [
            AppLayout::class,
            DashboardLayout::class,
        ]);
    }

    protected function configureAuth(): void
    {
        Auth::viaRequest('ordering', $this->app->make(OrderingGuard::class));
    }
}
