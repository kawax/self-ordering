<?php

declare(strict_types=1);

namespace Revolution\Ordering\Contracts\Payment;

use Illuminate\Support\Collection;

interface PaymentMethodFactory
{
    /**
     * @return Collection
     */
    public function methods(): Collection;

    /**
     * @return Collection
     */
    public function keys(): Collection;

    /**
     * @param  string  $key
     * @return string|null
     */
    public function name(string $key): ?string;
}
