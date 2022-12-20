<?php

declare(strict_types=1);

namespace Tests\Feature\Livewire;

use Livewire\Livewire;
use Revolution\Ordering\Contracts\Actions\Order;
use Revolution\Ordering\Facades\Cart;
use Revolution\Ordering\Http\Livewire\Order\Prepare;
use Tests\TestCase;

class LivewirePrepareTest extends TestCase
{
    public function testOrderPrepare()
    {
        $this->withoutVite();

        $response = $this->get(route('prepare', ['table' => 'test']));

        $response->assertStatus(200)
                 ->assertSeeLivewire('ordering.prepare');
    }

    public function testOrderPrepareDeleteCart()
    {

        Cart::shouldReceive('items')->twice()->andReturn(collect([]));
        Cart::shouldReceive('delete')->once();

        Livewire::test(Prepare::class)
                ->call('deleteCart', 0);
    }

    public function testOrderPrepareRedirectBack()
    {
        $this->withSession([
            'table' => 'test',
        ]);

        Livewire::test(Prepare::class)
                ->call('back')
                ->assertRedirect(route('order', ['table' => 'test']));
    }

    public function testOrderPrepareRedirect()
    {
        $this->mock(Order::class)
             ->shouldReceive('order')
             ->once();

        Livewire::test(Prepare::class)
                ->set('memo', 'test')
                ->call('redirectTo')
                ->assertRedirect(route('history'));
    }
}
