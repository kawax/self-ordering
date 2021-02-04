<?php

namespace Revolution\Ordering\Payment;

use PayPay\OpenPaymentAPI\Models\ModelException;
use Revolution\Ordering\Contracts\Payment\PaymentDriver;

class PaypayDriver implements PaymentDriver
{
    /**
     * @inheritDoc
     * @throws ModelException
     */
    public function redirect()
    {
        return app(PayPay::class)->redirect();
    }
}
