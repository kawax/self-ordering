<?php

declare(strict_types=1);

namespace Revolution\Ordering\Events\Payment;

use Illuminate\Foundation\Events\Dispatchable;

abstract class PayPayEvent
{
    use Dispatchable;

    /**
     * @param  array  $response
     */
    public function __construct(public array $response)
    {
        //
    }
}
