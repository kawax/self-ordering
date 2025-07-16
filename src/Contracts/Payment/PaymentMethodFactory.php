<?php

declare(strict_types=1);

namespace Revolution\Ordering\Contracts\Payment;

use Illuminate\Support\Collection;

interface PaymentMethodFactory
{
    public function methods(): Collection;

    public function keys(): Collection;

    public function name(string $key): ?string;
}
