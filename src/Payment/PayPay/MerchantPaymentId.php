<?php

namespace Revolution\Ordering\Payment\PayPay;

use Illuminate\Support\Str;

class MerchantPaymentId
{
    /**
     * @return string
     */
    public function create(): string
    {
        return Str::random(40);
    }
}
