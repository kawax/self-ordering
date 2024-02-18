<?php

declare(strict_types=1);

namespace Tests\Feature\Api;

use Revolution\Ordering\Facades\Menu;
use Tests\TestCase;

class MenusTest extends TestCase
{
    public function testMenusIndex()
    {
        Menu::shouldReceive('get')
            ->once()
            ->andReturn([
                [
                    'id' => 1,
                    'name' => 'test',
                    'price' => 100,
                    'category' => 'test',
                ],
            ]);

        $response = $this->get(route('api.menus.index'));

        $response->assertStatus(200)
                 ->assertJson([
                     [
                         'id' => 1,
                         'name' => 'test',
                         'price' => 100,
                         'category' => 'test',
                     ],
                 ]);
    }
}
