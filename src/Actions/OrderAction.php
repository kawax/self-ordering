<?php

namespace Revolution\Ordering\Actions;

use Illuminate\Support\Arr;
use Revolution\Ordering\Contracts\Actions\AddHistory;
use Revolution\Ordering\Contracts\Actions\Order;
use Revolution\Ordering\Contracts\Actions\ResetCart;
use Revolution\Ordering\Contracts\Payment\PaymentMethodFactory;
use Revolution\Ordering\Events\OrderEntry;
use Revolution\Ordering\Facades\Cart;
use Revolution\Ordering\Support\OrderId;

class OrderAction implements Order
{
    /**
     * @param  null|array  $options
     *
     * @return void
     */
    public function order(array $options = null): void
    {
        $items = Cart::all();
        $table = session('table');
        $memo = session('memo');

        app(ResetCart::class)->reset();

        if (empty($items)) {
            return;
        }

        $order_id = app(OrderId::class)->create();

        $date = now()->toDateTimeString();

        $payment = app(PaymentMethodFactory::class)
            ->name(Arr::get($options, 'payment', 'cash'));

        app(AddHistory::class)->add(compact([
            'order_id',
            'date',
            'items',
            'table',
            'memo',
            'payment',
        ]));

        OrderEntry::dispatch(
            $order_id,
            Cart::items($items)->toArray(),
            $table,
            $memo,
            $options,
        );

        session()->flash('order_completed_message', config('ordering.shop.order_completed_message'));
    }
}
