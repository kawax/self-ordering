<?php

namespace Revolution\Ordering\Payment;

use Revolution\Ordering\Contracts\Payment\PaymentDriver;
use Revolution\Ordering\Payment\PayPay\PayPay;

class PaypayDriver implements PaymentDriver
{
    /**
     * @inheritDoc
     */
    public function redirect()
    {
        return app(PayPay::class)->redirect();
    }
}
