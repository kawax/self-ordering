<?php

namespace Revolution\Ordering\Payment;

use Illuminate\Support\Collection;
use Illuminate\Support\Traits\Macroable;
use Revolution\Ordering\Contracts\Payment\PaymentMethodFactory;
use Revolution\Ordering\Payment\Concerns\WithPaymentMethodCollection;

class PaymentMethod implements PaymentMethodFactory
{
    use WithPaymentMethodCollection;
    use Macroable;

    /**
     * @return Collection
     */
    public function methods(): Collection
    {
        //  [
        //      'cash'   => 'レジで後払い',
        //      'paypay' => 'PayPay',
        //  ]

        return collect(config('ordering.payment.methods'));
    }
}
