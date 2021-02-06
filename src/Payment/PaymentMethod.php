<?php

namespace Revolution\Ordering\Payment;

use Illuminate\Support\Collection;
use Illuminate\Support\Traits\Macroable;
use Revolution\Ordering\Contracts\Payment\PaymentMethodFactory;

class PaymentMethod implements PaymentMethodFactory
{
    use Macroable;

    /**
     * @return Collection
     */
    public function methods(): Collection
    {
        return collect(config('ordering.payment.methods'));
    }
}
