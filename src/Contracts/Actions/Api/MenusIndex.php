<?php

namespace Revolution\Ordering\Contracts\Actions\Api;

use Illuminate\Http\Request;
use Illuminate\Http\Response;

interface MenusIndex
{
    /**
     * @param  Request  $request
     *
     * @return Response
     */
    public function __invoke(Request $request);
}
