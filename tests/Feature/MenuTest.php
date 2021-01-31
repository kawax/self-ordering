<?php

namespace Tests\Feature;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Http;
use Revolution\Ordering\Facades\Menu;
use Revolution\Ordering\Menu\ArrayDriver;
use Revolution\Ordering\Menu\MenuManager;
use Revolution\Ordering\Menu\MicroCmsDriver;
use Tests\TestCase;

class MenuTest extends TestCase
{
    public function testMenuManager()
    {
        $menu = new MenuManager(app());

        $this->assertEquals('array', $menu->getDefaultDriver());
    }

    public function testArrayDriver()
    {
        $driver = Menu::driver('array');
        $menus = $driver->get();

        $this->assertInstanceOf(ArrayDriver::class, $driver);
        $this->assertInstanceOf(Collection::class, $menus);
    }

    public function testMicroCmsDriver()
    {
        Http::fake([
            '*' => Http::response([
                'contents' => [
                    [
                        'id'    => 'test',
                        'image' => [
                            'url' => 'test',
                        ],
                    ],
                ],
            ]),
        ]);

        $driver = Menu::driver('micro-cms');
        $menus = $driver->get();

        $this->assertInstanceOf(MicroCmsDriver::class, $driver);
        $this->assertEquals([
            [
                'id'    => 'test',
                'image' => 'test',
            ],
        ], $menus->toArray());

        Http::assertSent(function ($request) {
            return $request->hasHeader('X-API-KEY');
        });
    }
}
