<?php

declare(strict_types=1);

namespace Revolution\Ordering\Contracts\Payment;

interface PaymentDriver
{
    public function redirect(): mixed;
}
