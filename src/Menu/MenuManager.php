<?php

namespace Revolution\Ordering\Menu;

use Illuminate\Support\Manager;
use Revolution\Ordering\Contracts\Menu\MenuDriver;
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
     * @return ArrayDriver|MenuDriver
     */
    public function createArrayDriver()
    {
        return app(ArrayDriver::class);
    }

    /**
     * @return MicroCmsDriver|MenuDriver
     */
    public function createMicroCmsDriver()
    {
        return app(MicroCmsDriver::class);
    }

    /**
     * @return GoogleSheetsDriver|MenuDriver
     */
    public function createGoogleSheetsDriver()
    {
        return app(GoogleSheetsDriver::class);
    }

    /**
     * @return ContentfulDriver|MenuDriver
     */
    public function createContentfulDriver()
    {
        return app(ContentfulDriver::class);
    }
}
