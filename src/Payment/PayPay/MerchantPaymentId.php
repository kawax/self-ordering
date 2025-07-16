<?php

declare(strict_types=1);

namespace Revolution\Ordering\Payment\PayPay;

use Illuminate\Support\Str;

class MerchantPaymentId
{
    public function create(): string
    {
        return Str::random(40);
    }
}
