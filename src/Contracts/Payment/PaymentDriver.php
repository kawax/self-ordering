<?php

declare(strict_types=1);

namespace Revolution\Ordering\Contracts\Payment;

interface PaymentDriver
{
    /**
     * @return mixed
     */
    public function redirect(): mixed;
}
