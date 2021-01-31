<?php

namespace Revolution\Ordering\Menu;

use Illuminate\Support\Manager;
use Revolution\Ordering\Contracts\Menu\MenuStorage;

class MenuManager extends Manager implements MenuStorage
{
    /**
     * @return string
     */
    public function getDefaultDriver()
    {
        return config('ordering.menu.driver', 'array');
    }

    /**
     * @return ArrayDriver
     */
    public function createArrayDriver()
    {
        return app(ArrayDriver::class);
    }

    /**
     * @return MicroCmsDriver
     */
    public function createMicroCmsDriver()
    {
        return app(MicroCmsDriver::class);
    }
}
