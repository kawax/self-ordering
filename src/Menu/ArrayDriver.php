<?php

namespace Revolution\Ordering\Menu;

use Revolution\Ordering\Contracts\Menu\MenuData;
use Revolution\Ordering\Contracts\Menu\MenuDriver;

class ArrayDriver implements MenuDriver
{
    /**
     * @return mixed
     */
    public function get()
    {
        return call_user_func(app(MenuData::class));
    }
}
