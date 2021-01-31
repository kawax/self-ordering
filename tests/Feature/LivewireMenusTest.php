<?php

namespace Tests\Feature;

use Illuminate\Foundation\Mix;
use Livewire\Livewire;
use Revolution\Ordering\Contracts\Actions\AddCart;
use Revolution\Ordering\Contracts\Actions\ResetCart;
use Revolution\Ordering\Http\Livewire\Order\Menus;
use Tests\TestCase;

class LivewireMenusTest extends TestCase
{
    public function testOrderMenus()
    {
        $this->mock(Mix::class)
             ->shouldReceive('__invoke');

        $response = $this->get(route('order', ['table' => 'test']));

        $response->assertStatus(200)
                 ->assertSessionHas('table', 'test')
                 ->assertSeeLivewire('ordering.menus');
    }

    public function testOrderMenusAddCart()
    {
        $this->mock(AddCart::class)
             ->shouldReceive('add')
             ->with('test')
             ->once();

        Livewire::test(Menus::class)
                ->set('menus', collect([]))
                ->call('addCart', 'test');
    }

    public function testOrderMenusResetCart()
    {
        $this->mock(ResetCart::class)
             ->shouldReceive('reset')
             ->once();

        Livewire::test(Menus::class)
                ->call('resetCart');
    }

    public function testOrderMenusRedirect()
    {
        Livewire::test(Menus::class)
                ->call('redirectTo')
                ->assertRedirect(route('prepare'));
    }
}
