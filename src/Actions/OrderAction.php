<?php

namespace Revolution\Ordering\Actions;

use Illuminate\Support\Collection;
use Revolution\Ordering\Contracts\Actions\AddHistory;
use Revolution\Ordering\Contracts\Actions\Order;
use Revolution\Ordering\Contracts\Actions\ResetCart;
use Revolution\Ordering\Events\OrderEntry;
use Revolution\Ordering\Facades\Menu;

class OrderAction implements Order
{
    /**
     * @param  null|mixed  $options
     *
     * @return mixed|void
     */
    public function order($options = null)
    {
        $date = now()->toDateTimeString();
        $items = session('cart', []);
        $table = session('table');
        $memo = session('memo');

        app(ResetCart::class)->reset();

        if (empty($items)) {
            return;
        }

        app(AddHistory::class)->add(compact([
            'date',
            'items',
            'table',
            'memo',
        ]));

        $menus = Collection::wrap(Menu::get());

        $items = collect($items)
            ->map(fn ($id) => $menus->firstWhere('id', $id))
            ->toArray();

        event(new OrderEntry($items, $table, $memo, $options));

        session()->flash('order-message', config('ordering.shop.order_message'));
    }
}
