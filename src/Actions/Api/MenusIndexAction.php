<?php

namespace Revolution\Ordering\Actions\Api;

use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Revolution\Ordering\Contracts\Actions\Api\MenusIndex;
use Revolution\Ordering\Facades\Menu;

class MenusIndexAction implements MenusIndex
{
    /**
     * @inheritDoc
     */
    public function __invoke(Request $request)
    {
        return Collection::wrap(Menu::get());
    }
}
