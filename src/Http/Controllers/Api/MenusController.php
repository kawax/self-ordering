<?php

namespace Revolution\Ordering\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Revolution\Ordering\Contracts\Actions\Api\MenusIndex;

class MenusController
{
    /**
     * @param  Request  $request
     *
     * @return Response
     */
    public function __invoke(Request $request)
    {
        return app(MenusIndex::class)($request);
    }
}
