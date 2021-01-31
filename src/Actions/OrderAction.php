<?php

namespace Revolution\Ordering\Actions;

use Revolution\Ordering\Contracts\Actions\AddHistory;
use Revolution\Ordering\Contracts\Actions\Order;
use Revolution\Ordering\Contracts\Actions\ResetCart;
use Revolution\Ordering\Events\OrderEntry;
use Revolution\Ordering\Facades\Menu;

class OrderAction implements Order
{
    public function order()
    {
        $date = now()->toDateTimeString();
        $items = session('cart', []);
        $table = session('table');
        $memo = session('memo');

        app(ResetCart::class)->reset();

        app(AddHistory::class)->add(compact([
            'date',
            'items',
            'table',
            'memo',
        ]));

        $menus = Menu::get();

        $items = collect($items)
            ->map(fn ($id) => $menus->firstWhere('id', $id))
            ->toArray();

        event(new OrderEntry($items, $table, $memo));

        session()->flash('order-message', config('ordering.shop.order_message'));
    }
}
