<?php

namespace Revolution\Ordering\Contracts\Actions;

use Illuminate\Http\Request;

interface Login
{
    /**
     * @param  Request  $request
     *
     * @return mixed
     */
    public function __invoke(Request $request);
}
