<?php

namespace Revolution\Ordering\Http\Controllers\Auth;

use Illuminate\Http\Request;
use Revolution\Ordering\Contracts\Actions\Logout;

class LogoutController
{
    /**
     * @param  Request  $request
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function __invoke(Request $request)
    {
        return app(Logout::class)($request);
    }
}
