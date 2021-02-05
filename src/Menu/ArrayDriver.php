<?php

namespace Revolution\Ordering\Menu;

use Illuminate\Support\Traits\Macroable;
use Revolution\Ordering\Contracts\Menu\MenuData;
use Revolution\Ordering\Contracts\Menu\MenuDriver;

class ArrayDriver implements MenuDriver
{
    use Macroable;

    /**
     * @return mixed
     */
    public function get()
    {
        return call_user_func(app(MenuData::class));
    }
}
