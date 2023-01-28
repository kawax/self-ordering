<?php

declare(strict_types=1);

namespace Revolution\Ordering\Providers\Concerns;

use Revolution\Ordering\Actions\AddCartAction;
use Revolution\Ordering\Actions\AddHistoryAction;
use Revolution\Ordering\Actions\Api\MenusIndexAction;
use Revolution\Ordering\Actions\LoginAction;
use Revolution\Ordering\Actions\LogoutAction;
use Revolution\Ordering\Actions\OrderAction;
use Revolution\Ordering\Actions\ResetCartAction;
use Revolution\Ordering\Auth\OrderingRequestGuard;
use Revolution\Ordering\Cart\SessionCart;
use Revolution\Ordering\Contracts\Actions\AddCart;
use Revolution\Ordering\Contracts\Actions\AddHistory;
use Revolution\Ordering\Contracts\Actions\Api\MenusIndex;
use Revolution\Ordering\Contracts\Actions\Login;
use Revolution\Ordering\Contracts\Actions\Logout;
use Revolution\Ordering\Contracts\Actions\Order;
use Revolution\Ordering\Contracts\Actions\ResetCart;
use Revolution\Ordering\Contracts\Auth\OrderingGuard;
use Revolution\Ordering\Contracts\Cart\CartFactory;
use Revolution\Ordering\Contracts\Menu\MenuData;
use Revolution\Ordering\Contracts\Menu\MenuStorage;
use Revolution\Ordering\Contracts\Payment\PaymentFactory;
use Revolution\Ordering\Contracts\Payment\PaymentMethodFactory;
use Revolution\Ordering\Menu\MenuManager;
use Revolution\Ordering\Menu\SampleMenu;
use Revolution\Ordering\Payment\PaymentManager;
use Revolution\Ordering\Payment\PaymentMethod;

trait WithBindings
{
    protected function registerBindings(): void
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
        $this->app->singleton(PaymentFactory::class, PaymentManager::class);
        $this->app->singleton(PaymentMethodFactory::class, PaymentMethod::class);
        $this->app->singleton(CartFactory::class, SessionCart::class);

        $this->app->singleton(MenusIndex::class, MenusIndexAction::class);
    }
}
