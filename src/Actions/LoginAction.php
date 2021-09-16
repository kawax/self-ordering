<?php

declare(strict_types=1);

namespace Revolution\Ordering\Actions;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Revolution\Ordering\Contracts\Actions\Login;
use Revolution\Ordering\Events\Auth\Failed;
use Revolution\Ordering\Events\Auth\Login as LoginEvent;

class LoginAction implements Login
{
    /**
     * @param  Request  $request
     * @return mixed
     */
    public function __invoke(Request $request)
    {
        $validator = validator($request->all(), [
            'password' => [
                'required',
                Rule::in([config('ordering.admin.password')]),
            ],
        ]);

        if ($validator->fails()) {
            Failed::dispatch($request);

            return back()->withoutCookie(config('ordering.cookie'));
        }

        LoginEvent::dispatch($request);

        return redirect()->route('dashboard')
                         ->cookie(config('ordering.cookie'), true);
    }
}
