<?php

namespace Tests\Feature\Livewire;

use Illuminate\Foundation\Mix;
use Livewire\Livewire;
use Mockery\MockInterface;
use Revolution\Ordering\Contracts\Actions\Order;
use Revolution\Ordering\Http\Livewire\Order\PayPay;
use Revolution\Ordering\Payment\PayPay as PaymentPayPay;
use Tests\TestCase;

class LivewirePayPayTest extends TestCase
{
    public function testPayPayView()
    {
        $this->mock(Mix::class)
             ->shouldReceive('__invoke');

        $response = $this->get(route('paypay.callback', ['payment' => 'test']));

        $response->assertStatus(200)
                 ->assertSeeLivewire('ordering.paypay');
    }

    public function testPayPayRedirectBack()
    {
        $this->withSession([
            'table' => 'test',
        ]);

        Livewire::test(PayPay::class)
                ->call('back')
                ->assertRedirect(route('order', ['table' => 'test']));
    }

    public function testPayPayCheckOk()
    {
        $this->mock(PaymentPayPay::class, function (MockInterface $mock) {
            $mock->shouldReceive('getPaymentDetails')
                 ->andReturn([
                     'status' => 'COMPLETED',
                 ]);
        });

        $this->mock(Order::class)
             ->shouldReceive('order')
             ->once();

        Livewire::test(PayPay::class)
                ->set('payment', 'test')
                ->call('check')
                ->assertRedirect(route('history'));
    }

    public function testPayPayCheckFailed()
    {
        $this->mock(PaymentPayPay::class, function (MockInterface $mock) {
            $mock->shouldReceive('getPaymentDetails')
                 ->andReturn([
                     'status' => 'FAILED',
                 ]);
        });

        $this->mock(Order::class)
             ->shouldReceive('order')
             ->never();

        Livewire::test(PayPay::class)
                ->set('payment', 'test')
                ->call('check')
                ->assertSet('status', 'FAILED');
    }
}
