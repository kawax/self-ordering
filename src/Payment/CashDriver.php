<?php

namespace Revolution\Ordering\Payment;

use Revolution\Ordering\Contracts\Actions\Order;
use Revolution\Ordering\Contracts\Payment\PaymentDriver;

class CashDriver implements PaymentDriver
{
    /**
     * @return mixed
     */
    public function redirect()
    {
        // cashの場合はここで注文送信
        $options = [
            'payment' => 'cash',
        ];

        app(Order::class)->order($options);

        return redirect()->route(config('ordering.redirect.from_payment'));
    }
}
