<?php

namespace Revolution\Ordering\Providers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;
use Livewire\Livewire;
use Revolution\Ordering\Actions\AddCartAction;
use Revolution\Ordering\Actions\AddHistoryAction;
use Revolution\Ordering\Actions\LoginAction;
use Revolution\Ordering\Actions\LogoutAction;
use Revolution\Ordering\Actions\OrderAction;
use Revolution\Ordering\Actions\ResetCartAction;
use Revolution\Ordering\Auth\OrderingRequestGuard;
use Revolution\Ordering\Console\InstallCommand;
use Revolution\Ordering\Contracts\Actions\AddCart;
use Revolution\Ordering\Contracts\Actions\AddHistory;
use Revolution\Ordering\Contracts\Actions\Login;
use Revolution\Ordering\Contracts\Actions\Logout;
use Revolution\Ordering\Contracts\Actions\Order;
use Revolution\Ordering\Contracts\Actions\ResetCart;
use Revolution\Ordering\Contracts\Auth\OrderingGuard;
use Revolution\Ordering\Contracts\Menu\MenuData;
use Revolution\Ordering\Contracts\Menu\MenuStorage;
use Revolution\Ordering\Http\Livewire\Order\History;
use Revolution\Ordering\Http\Livewire\Order\Menus;
use Revolution\Ordering\Http\Livewire\Order\Prepare;
use Revolution\Ordering\Menu\MenuManager;
use Revolution\Ordering\Menu\SampleMenu;
use Revolution\Ordering\View\Components\AppLayout;
use Revolution\Ordering\View\Components\GuestLayout;

class OrderingServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->registerBindings();

        $this->registerLivewire();

        config([
            'auth.guards.ordering' => array_merge([
                'driver'   => 'ordering',
                'provider' => null,
            ], config('auth.guards.ordering', [])),
        ]);

        if (! $this->app->configurationIsCached()) {
            $this->mergeConfigFrom(__DIR__.'/../../config/ordering.php', 'ordering');
        }
    }

    protected function registerBindings()
    {
        $this->app->singleton(OrderingGuard::class, OrderingRequestGuard::class);
        $this->app->singleton(Login::class, LoginAction::class);
        $this->app->singleton(Logout::class, LogoutAction::class);
        $this->app->singleton(MenuStorage::class, MenuManager::class);
        $this->app->singleton(MenuData::class, SampleMenu::class);
        $this->app->singleton(AddCart::class, AddCartAction::class);
        $this->app->singleton(ResetCart::class, ResetCartAction::class);
        $this->app->singleton(Order::class, OrderAction::class);
        $this->app->singleton(AddHistory::class, AddHistoryAction::class);
    }

    protected function registerLivewire()
    {
        Livewire::component('order.menus', Menus::class);
        Livewire::component('order.prepare', Prepare::class);
        Livewire::component('order.history', History::class);
    }

    public function boot()
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

    protected function configureView()
    {
        $this->loadViewsFrom(__DIR__.'/../../resources/views', 'ordering');

        $this->loadViewComponentsAs('ordering', [
            AppLayout::class,
            GuestLayout::class,
        ]);
    }

    protected function configureAuth()
    {
        Auth::viaRequest('ordering', $this->app->make(OrderingGuard::class));
    }

    protected function configureRoutes()
    {
        if (! config('ordering.routes', true)) {
            return; // @codeCoverageIgnore
        }

        Route::middleware(config('ordering.middleware', 'web'))
             ->domain(config('ordering.domain'))
             ->prefix(config('ordering.prefix'))
             ->group(function () {
                 $this->loadRoutesFrom(__DIR__.'/../../routes/web.php');
             });
    }
}
