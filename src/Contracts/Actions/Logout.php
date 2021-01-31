<?php

namespace Revolution\Ordering\Contracts\Actions;

use Illuminate\Http\Request;

interface Logout
{
    /**
     * @param  Request  $request
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function __invoke(Request $request);
}
