<?php

namespace Revolution\Ordering\Payment;

use Illuminate\Support\Collection;

class PaymentMethod
{
    /**
     * @return Collection
     */
    public function get(): Collection
    {
        return collect(config('ordering.payment.methods'));
    }
}
