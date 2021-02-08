<?php

namespace Revolution\Ordering\Contracts\Payment;

interface PaymentDriver
{
    /**
     * @return mixed
     */
    public function redirect();
}
