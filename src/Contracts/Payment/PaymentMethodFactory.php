<?php

namespace Revolution\Ordering\Contracts\Payment;

use Illuminate\Support\Collection;

interface PaymentMethodFactory
{
    /**
     * @return Collection
     */
    public function methods(): Collection;
}
