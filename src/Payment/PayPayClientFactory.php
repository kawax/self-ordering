<?php

namespace Revolution\Ordering\Payment;

use PayPay\OpenPaymentAPI\Client;
use PayPay\OpenPaymentAPI\ClientException;

class PayPayClientFactory
{
    /**
     * @return Client
     * @throws ClientException
     */
    public function __invoke(): Client
    {
        return new Client([
            'API_KEY'     => config('ordering.payment.paypay.api_key'),
            'API_SECRET'  => config('ordering.payment.paypay.api_secret'),
            'MERCHANT_ID' => config('ordering.payment.paypay.merchant_id'),
        ], config('ordering.payment.paypay.production', false));
    }
}
