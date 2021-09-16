<?php

declare(strict_types=1);

namespace Revolution\Ordering\Contracts\Actions;

use Illuminate\Http\Request;

interface Logout
{
    /**
     * @param  Request  $request
     * @return mixed
     */
    public function __invoke(Request $request);
}
