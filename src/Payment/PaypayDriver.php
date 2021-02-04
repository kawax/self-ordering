<?php

namespace Revolution\Ordering\Payment;

use PayPay\OpenPaymentAPI\Controller\ClientControllerException;
use PayPay\OpenPaymentAPI\Models\ModelException;
use Revolution\Ordering\Contracts\Payment\PaymentDriver;
use Revolution\Ordering\Payment\PayPay\PayPay;

class PaypayDriver implements PaymentDriver
{
    /**
     * @inheritDoc
     * @throws ModelException
     * @throws ClientControllerException
     */
    public function redirect()
    {
        return app(PayPay::class)->redirect();
    }
}
