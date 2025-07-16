<?php

declare(strict_types=1);

namespace Revolution\Ordering\Payment;

use Illuminate\Support\Manager;
use Revolution\Ordering\Contracts\Payment\PaymentDriver;
use Revolution\Ordering\Contracts\Payment\PaymentFactory;

class PaymentManager extends Manager implements PaymentFactory
{
    /**
     * {@inheritDoc}
     */
    public function getDefaultDriver()
    {
        return 'cash';
    }

    public function createCashDriver(): CashDriver|PaymentDriver
    {
        return app(CashDriver::class);
    }

    public function createPaypayDriver(): PaypayDriver|PaymentDriver
    {
        return app(PaypayDriver::class);
    }
}
