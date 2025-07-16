<?php

declare(strict_types=1);

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

    public function createArrayDriver(): ArrayDriver|MenuDriver
    {
        return app(ArrayDriver::class);
    }

    public function createMicroCmsDriver(): MicroCmsDriver|MenuDriver
    {
        return app(MicroCmsDriver::class);
    }

    public function createGoogleSheetsDriver(): GoogleSheetsDriver|MenuDriver
    {
        return app(GoogleSheetsDriver::class);
    }

    public function createContentfulDriver(): ContentfulDriver|MenuDriver
    {
        return app(ContentfulDriver::class);
    }
}
