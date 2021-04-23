<?php

declare(strict_types=1);

namespace Tests\Feature;

use Google_Service_Sheets;
use Google_Service_Sheets_Resource_SpreadsheetsValues as SpreadsheetsValues;
use Illuminate\Http\Client\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Http;
use Revolution\Ordering\Facades\Menu;
use Revolution\Ordering\Menu\ArrayDriver;
use Revolution\Ordering\Menu\ContentfulDriver;
use Revolution\Ordering\Menu\GoogleSheetsDriver;
use Revolution\Ordering\Menu\MenuManager;
use Revolution\Ordering\Menu\MicroCmsDriver;
use Tests\TestCase;

class MenuTest extends TestCase
{
    public function testMenuManager()
    {
        $menu = new MenuManager(app());

        $this->assertSame('array', $menu->getDefaultDriver());
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
        $this->assertSame([
            [
                'id'    => 'test',
                'image' => 'test'.config('ordering.menu.micro-cms.image'),
            ],
        ], $menus->toArray());

        Http::assertSent(fn ($request) => $request->hasHeader('X-API-KEY'));
    }

    public function testGoogleSheetsDriver()
    {
        $values = $this->mock(SpreadsheetsValues::class, function ($mock) {
            $mock->shouldReceive('get->getValues')
                 ->once()
                 ->andReturn([
                     [
                         'id',
                         'name',
                     ],
                     [
                         1,
                         'test',
                     ],
                     [
                         2,
                         'test',
                     ],
                 ]);
        });

        $this->instance('ordering.google.sheets.values', $values);

        $driver = Menu::driver('google-sheets');
        $menus = $driver->get();

        $this->assertInstanceOf(GoogleSheetsDriver::class, $driver);
        $this->assertInstanceOf(Collection::class, $menus);
        $this->assertSame([
            ['id' => 1, 'name' => 'test'],
            ['id' => 2, 'name' => 'test'],
        ], $menus->toArray());
    }

    public function testGoogleSheetsInstance()
    {
        $this->assertInstanceOf(
            Google_Service_Sheets::class,
            app('ordering.google.sheets')
        );
    }

    public function testGoogleSheetsValuesInstance()
    {
        $this->assertInstanceOf(
            SpreadsheetsValues::class,
            app('ordering.google.sheets.values')
        );
    }

    public function testContentfulDriver()
    {
        Http::fake([
            '*' => Http::response([
                'items'    => [
                    [
                        'sys'    => [
                            'id' => 'test',
                        ],
                        'fields' => [
                            'name'  => 'name',
                            'image' => [
                                'sys' => [
                                    'id' => 'image_id',
                                ],
                            ],
                        ],
                    ],
                ],
                'includes' => [
                    'Asset' => [
                        [
                            'sys'    => [
                                'id' => 'image_id',
                            ],
                            'fields' => [
                                'file' => [
                                    'url' => '//image',
                                ],
                            ],
                        ],
                    ],
                ],
            ]),
        ]);

        $driver = Menu::driver('contentful');
        $menus = $driver->get();

        $this->assertInstanceOf(ContentfulDriver::class, $driver);
        $this->assertSame([
            [
                'id'       => 'test',
                'name'     => 'name',
                'text'     => null,
                'category' => null,
                'price'    => null,
                'image'    => '//image',
            ],
        ], $menus->toArray());

        Http::assertSent(fn (Request $request) => $request->hasHeader('Authorization'));
    }
}
