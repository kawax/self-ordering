<?php

namespace Revolution\Ordering\Actions;

use Illuminate\Http\Request;
use Revolution\Ordering\Contracts\Actions\Logout;
use Revolution\Ordering\Events\Auth\Logout as LogoutEvent;

class LogoutAction implements Logout
{
    /**
     * @param  Request  $request
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function __invoke(Request $request)
    {
        LogoutEvent::dispatch($request);

        return redirect()->route('dashboard')
                         ->withoutCookie(config('ordering.cookie'));
    }
}
