<?php

namespace Revolution\Ordering\Facades;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Facade;
use Revolution\Ordering\Contracts\Menu\MenuDriver;
use Revolution\Ordering\Contracts\Menu\MenuStorage;

/**
 * @method static array|Collection|mixed get()
 * @method static MenuDriver driver($driver)
 */
class Menu extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return MenuStorage::class;
    }
}
