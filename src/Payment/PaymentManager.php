<?php

declare(strict_types=1);

namespace Revolution\Ordering\Payment;

use Illuminate\Support\Manager;
use Revolution\Ordering\Contracts\Payment\PaymentDriver;
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
     * @return CashDriver|PaymentDriver
     */
    public function createCashDriver(): CashDriver|PaymentDriver
    {
        return app(CashDriver::class);
    }

    /**
     * @return PaypayDriver|PaymentDriver
     */
    public function createPaypayDriver(): PaypayDriver|PaymentDriver
    {
        return app(PaypayDriver::class);
    }
}
