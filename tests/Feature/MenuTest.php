<?php

declare(strict_types=1);

namespace Tests\Feature;

use Google\Service\Sheets;
use Google\Service\Sheets\Resource\SpreadsheetsValues;
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
    public function test_menu_manager()
    {
        $menu = new MenuManager(app());

        $this->assertSame('array', $menu->getDefaultDriver());
    }

    public function test_array_driver()
    {
        $driver = Menu::driver('array');
        $menus = $driver->get();

        $this->assertInstanceOf(ArrayDriver::class, $driver);
        $this->assertInstanceOf(Collection::class, $menus);
    }

    public function test_micro_cms_driver()
    {
        Http::fake([
            '*' => Http::response([
                'contents' => [
                    [
                        'id' => 'test',
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
                'id' => 'test',
                'image' => 'test'.config('ordering.menu.micro-cms.image'),
            ],
        ], $menus->toArray());

        Http::assertSent(fn ($request) => $request->hasHeader('X-API-KEY'));
    }

    public function test_google_sheets_driver()
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

    public function test_google_sheets_instance()
    {
        $this->assertInstanceOf(
            Sheets::class,
            app('ordering.google.sheets')
        );
    }

    public function test_google_sheets_values_instance()
    {
        $this->assertInstanceOf(
            SpreadsheetsValues::class,
            app('ordering.google.sheets.values')
        );
    }

    public function test_contentful_driver()
    {
        Http::fake([
            '*' => Http::response([
                'items' => [
                    [
                        'sys' => [
                            'id' => 'test',
                        ],
                        'fields' => [
                            'name' => 'name',
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
                            'sys' => [
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
                'id' => 'test',
                'name' => 'name',
                'text' => null,
                'category' => null,
                'price' => null,
                'image' => '//image',
            ],
        ], $menus->toArray());

        Http::assertSent(fn (Request $request) => $request->hasHeader('Authorization'));
    }
}
