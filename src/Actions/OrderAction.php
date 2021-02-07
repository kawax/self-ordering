<?php

namespace Revolution\Ordering\Actions;

use Illuminate\Support\Arr;
use Revolution\Ordering\Contracts\Actions\AddHistory;
use Revolution\Ordering\Contracts\Actions\Order;
use Revolution\Ordering\Contracts\Actions\ResetCart;
use Revolution\Ordering\Contracts\Payment\PaymentMethodFactory;
use Revolution\Ordering\Events\OrderEntry;
use Revolution\Ordering\Facades\Cart;

class OrderAction implements Order
{
    /**
     * @param  null|mixed  $options
     *
     * @return mixed|void
     */
    public function order($options = null)
    {
        $items = Cart::all();
        $table = session('table');
        $memo = session('memo');

        app(ResetCart::class)->reset();

        if (empty($items)) {
            return;
        }

        $date = now()->toDateTimeString();

        $payment = app(PaymentMethodFactory::class)
            ->name(Arr::get($options, 'payment', 'cash'));

        app(AddHistory::class)->add(compact([
            'date',
            'items',
            'table',
            'memo',
            'payment',
        ]));

        OrderEntry::dispatch(
            Cart::items($items)->toArray(),
            $table,
            $memo,
            $options,
        );

        session()->flash('order_message', config('ordering.shop.order_message'));
    }
}
