<?php

namespace Revolution\Ordering\Contracts\Payment;

use Illuminate\Http\RedirectResponse;

interface PaymentDriver
{
    /**
     * @return RedirectResponse
     */
    public function redirect();
}
