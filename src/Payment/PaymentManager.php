<?php

namespace Revolution\Ordering\Payment;

use Illuminate\Support\Manager;
use Revolution\Ordering\Contracts\Payment\PaymentFactory;

class PaymentManager extends Manager implements PaymentFactory
{
    /**
     * @inheritDoc
     */
    public function getDefaultDriver()
    {
        return 'cash';
    }

    /**
     * @return CashDriver
     */
    public function createCashDriver()
    {
        return app(CashDriver::class);
    }

    /**
     * @return PaypayDriver
     */
    public function createPaypayDriver()
    {
        return app(PaypayDriver::class);
    }
}
