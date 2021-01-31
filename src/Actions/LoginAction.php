<?php

namespace Revolution\Ordering\Actions;

use Illuminate\Http\Request;
use Revolution\Ordering\Contracts\Actions\Login;

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
            return back()->withoutCookie(config('ordering.cookie'));
        }

        return redirect()->route('dashboard')
                         ->cookie(config('ordering.cookie'), true);
    }
}
