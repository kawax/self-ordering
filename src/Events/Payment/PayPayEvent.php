<?php

declare(strict_types=1);

namespace Revolution\Ordering\Events\Payment;

use Illuminate\Foundation\Events\Dispatchable;

abstract class PayPayEvent
{
    use Dispatchable;

    /**
     * @var array
     */
    public array $response;

    /**
     * @param  array  $response
     */
    public function __construct(array $response)
    {
        $this->response = $response;
    }
}
