<?php

namespace Tests\Feature\Livewire;

use Illuminate\Support\Arr;
use Livewire\Livewire;
use Mockery\MockInterface;
use Revolution\Ordering\Contracts\Actions\Order;
use Revolution\Ordering\Http\Livewire\Order\PayPayCallback;
use Revolution\Ordering\Payment\PayPay\PayPay;
use Tests\TestCase;

class LivewirePayPayTest extends TestCase
{
    public function testPayPayView()
    {
        $this->withoutMix();

        $response = $this->get(route('paypay.callback', ['payment' => 'test']));

        $response->assertStatus(200)
                 ->assertSeeLivewire('ordering.paypay');
    }

    public function testPayPayRedirectBack()
    {
        $this->withSession([
            'table' => 'test',
        ]);

        Livewire::test(PayPayCallback::class)
                ->call('back')
                ->assertRedirect(route('order', ['table' => 'test']));
    }

    public function testPayPayCheckOk()
    {
        $this->mock(PayPay::class, function (MockInterface $mock) {
            $mock->shouldReceive('getPaymentDetails')
                 ->andReturn(Arr::add([], 'data.status', 'COMPLETED'));
        });

        $this->mock(Order::class)
             ->shouldReceive('order')
             ->once();

        Livewire::test(PayPayCallback::class)
                ->set('payment', 'test')
                ->call('check')
                ->assertRedirect(route('history'));
    }

    public function testPayPayCheckFailed()
    {
        $this->mock(PayPay::class, function (MockInterface $mock) {
            $mock->shouldReceive('getPaymentDetails')
                 ->andReturn(Arr::add([], 'data.status', 'FAILED'));
        });

        $this->mock(Order::class)
             ->shouldReceive('order')
             ->never();

        Livewire::test(PayPayCallback::class)
                ->set('payment', 'test')
                ->call('check')
                ->assertSet('status', 'FAILED');
    }
}
