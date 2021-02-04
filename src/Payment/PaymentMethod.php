<?php

namespace Revolution\Ordering\Payment;

use Illuminate\Support\Collection;

class PaymentMethod
{
    /**
     * @return Collection
     */
    public function methods(): Collection
    {
        return collect(config('ordering.payment.methods'));
    }
}
