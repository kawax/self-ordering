<?php

declare(strict_types=1);

namespace Revolution\Ordering\Contracts\Actions\Api;

use Illuminate\Http\Request;

interface MenusIndex
{
    /**
     * @return mixed
     */
    public function __invoke(Request $request);
}
