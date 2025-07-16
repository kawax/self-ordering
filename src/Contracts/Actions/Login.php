<?php

declare(strict_types=1);

namespace Revolution\Ordering\Contracts\Actions;

use Illuminate\Http\Request;

interface Login
{
    /**
     * @return mixed
     */
    public function __invoke(Request $request);
}
