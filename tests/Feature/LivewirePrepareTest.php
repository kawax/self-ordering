<?php

namespace Tests\Feature;

use Illuminate\Foundation\Mix;
use Livewire\Livewire;
use Revolution\Ordering\Contracts\Actions\Order;
use Revolution\Ordering\Http\Livewire\Order\Prepare;
use Tests\TestCase;

class LivewirePrepareTest extends TestCase
{
    public function testOrderPrepare()
    {
        $this->mock(Mix::class)
             ->shouldReceive('__invoke');

        $response = $this->get(route('prepare', ['table' => 'test']));

        $response->assertStatus(200)
                 ->assertSeeLivewire('order.prepare');
    }

    public function testOrderPrepareDeleteCart()
    {
        Livewire::test(Prepare::class)
                ->call('deleteCart', 0);
    }

    public function testOrderPrepareRedirect()
    {
        $this->withSession([
            'table' => 'test',
        ]);

        Livewire::test(Prepare::class)
                ->call('back')
                ->assertRedirect(route('order', ['table' => 'test']));
    }

    public function testOrderPrepareSendOrder()
    {
        $this->mock(Order::class)
             ->shouldReceive('order')
             ->once();

        Livewire::test(Prepare::class)
                ->set('memo', 'test')
                ->call('sendOrder')
                ->assertRedirect(route('history'));
    }
}
