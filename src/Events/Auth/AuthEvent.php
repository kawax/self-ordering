<?php

declare(strict_types=1);

namespace Revolution\Ordering\Events\Auth;

use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Http\Request;

abstract class AuthEvent
{
    use Dispatchable;

    public Request $request;

    /**
     * @param  Request  $request
     */
    public function __construct(Request $request)
    {
        $this->request = $request;
    }
}
