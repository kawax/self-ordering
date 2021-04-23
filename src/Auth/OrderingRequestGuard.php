<?php

declare(strict_types=1);

namespace Revolution\Ordering\Auth;

use Illuminate\Auth\GenericUser;
use Illuminate\Http\Request;
use Revolution\Ordering\Contracts\Auth\OrderingGuard;

class OrderingRequestGuard implements OrderingGuard
{
    /**
     * @param  Request  $request
     *
     * @return GenericUser|null
     */
    public function __invoke(Request $request)
    {
        if (! $request->cookie(config('ordering.cookie'))) {
            return null;
        }

        return new GenericUser([
            'name'  => 'admin',
            'email' => '',
        ]);
    }
}
