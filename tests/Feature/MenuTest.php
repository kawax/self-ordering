<?php

namespace Tests\Feature;

use Google_Service_Sheets;
use Google_Service_Sheets_Resource_SpreadsheetsValues as SpreadsheetsValues;
use Google_Service_Sheets_ValueRange as ValueRange;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Http;
use Mockery;
use Revolution\Ordering\Facades\Menu;
use Revolution\Ordering\Menu\ArrayDriver;
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
        $value_range = $this->mock(ValueRange::class);
        $value_range->values = [
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
        ];

        $values = $this->mock(SpreadsheetsValues::class, function ($mock) use ($value_range) {
            $mock->shouldReceive('get')
                 ->once()
                 ->andReturn($value_range);
        });

        $sheets = Mockery::mock(Google_Service_Sheets::class);
        $sheets->spreadsheets_values = $values;
        $this->instance('ordering.google.sheets', $sheets);

        $driver = Menu::driver('google-sheets');
        $menus = $driver->get();

        $this->assertInstanceOf(GoogleSheetsDriver::class, $driver);
        $this->assertInstanceOf(Collection::class, $menus);
        $this->assertSame([
            ['id' => 1, 'name' => 'test'],
            ['id' => 2, 'name' => 'test'],
        ], $menus->toArray());
    }

    public function testGoogleSheetsDriverInstance()
    {
        $this->assertInstanceOf(
            Google_Service_Sheets::class,
            app('ordering.google.sheets')
        );
    }
}
