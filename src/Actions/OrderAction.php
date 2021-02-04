<?php

namespace Revolution\Ordering\Actions;

use Illuminate\Support\Arr;
use Revolution\Ordering\Contracts\Actions\AddHistory;
use Revolution\Ordering\Contracts\Actions\Order;
use Revolution\Ordering\Contracts\Actions\ResetCart;
use Revolution\Ordering\Events\OrderEntry;
use Revolution\Ordering\Payment\PaymentMethod;
use Revolution\Ordering\Support\Cart;

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

        $payment = app(PaymentMethod::class)
            ->methods()
            ->get(Arr::get($options, 'payment', 'cash'));

        app(ResetCart::class)->reset();

        if (empty($items)) {
            return;
        }

        app(AddHistory::class)->add(compact([
            'date',
            'items',
            'table',
            'memo',
            'payment',
        ]));

        $items = Cart::items($items)->toArray();

        event(new OrderEntry($items, $table, $memo, $options));

        session()->flash('order-message', config('ordering.shop.order_message'));
    }
}
