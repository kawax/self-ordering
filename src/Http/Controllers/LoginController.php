<?php

namespace Revolution\Ordering\Http\Controllers;

use Illuminate\Http\Request;
use Revolution\Ordering\Contracts\Actions\Login;

class LoginController
{
    /**
     * @param  Request  $request
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function __invoke(Request $request)
    {
        return app(Login::class)($request);
    }
}
