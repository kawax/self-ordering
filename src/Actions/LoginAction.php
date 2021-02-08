<?php

namespace Revolution\Ordering\Actions;

use Illuminate\Http\Request;
use Revolution\Ordering\Contracts\Actions\Login;
use Revolution\Ordering\Events\Auth\Failed;
use Revolution\Ordering\Events\Auth\Login as LoginEvent;

class LoginAction implements Login
{
    /**
     * @param  Request  $request
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function __invoke(Request $request)
    {
        if ($request->missing('password') ||
            $request->input('password') !== config('ordering.admin.password')) {
            Failed::dispatch($request);

            return back()->withoutCookie(config('ordering.cookie'));
        }

        LoginEvent::dispatch($request);

        return redirect()->route('dashboard')
                         ->cookie(config('ordering.cookie'), true);
    }
}
