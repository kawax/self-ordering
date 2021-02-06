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
        //  [
        //      'cash'   => 'レジで後払い',
        //      'paypay' => 'PayPay',
        //  ]

        return collect(config('ordering.payment.methods'));
    }

    /**
     * @return Collection
     */
    public function keys(): Collection
    {
        return $this->methods()->keys();
    }

    /**
     * @param  string  $key
     *
     * @return string|null
     */
    public function name(string $key): ?string
    {
        return $this->methods()->get($key);
    }
}
