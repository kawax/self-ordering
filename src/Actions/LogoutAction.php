<?php

namespace Revolution\Ordering\Actions;

use Illuminate\Http\Request;
use Revolution\Ordering\Contracts\Actions\Logout;

class LogoutAction implements Logout
{
    /**
     * @param  Request  $request
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function __invoke(Request $request)
    {
        return redirect()->route('dashboard')
                         ->withoutCookie(config('ordering.cookie'));
    }
}
