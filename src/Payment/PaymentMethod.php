<?php

namespace Revolution\Ordering\Payment;

use Illuminate\Support\Collection;
use Illuminate\Support\Traits\Macroable;

class PaymentMethod
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
