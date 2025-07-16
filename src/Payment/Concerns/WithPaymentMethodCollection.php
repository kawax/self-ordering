<?php

declare(strict_types=1);

namespace Revolution\Ordering\Payment\Concerns;

use Illuminate\Support\Collection;
use Revolution\Ordering\Payment\PaymentMethod;

/**
 * @see PaymentMethod
 */
trait WithPaymentMethodCollection
{
    public function keys(): Collection
    {
        return $this->methods()->keys();
    }

    public function name(string $key): ?string
    {
        return $this->methods()->get($key);
    }
}
