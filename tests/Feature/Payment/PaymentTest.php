<?php

namespace Tests\Feature\Payment;

use Illuminate\Http\RedirectResponse;
use Revolution\Ordering\Contracts\Actions\Order;
use Revolution\Ordering\Facades\Payment;
use Revolution\Ordering\Payment\CashDriver;
use Revolution\Ordering\Payment\PaymentManager;
use Revolution\Ordering\Payment\PayPay;
use Revolution\Ordering\Payment\PaypayDriver;
use Tests\TestCase;

class PaymentTest extends TestCase
{
    public function testPaymentManager()
    {
        $menu = new PaymentManager(app());

        $this->assertEquals('cash', $menu->getDefaultDriver());
    }

    public function testCashDriver()
    {
        $this->mock(Order::class)
             ->shouldReceive('order')
             ->once();

        $driver = Payment::driver('cash');
        $redirect = $driver->redirect();

        $this->assertInstanceOf(CashDriver::class, $driver);
        $this->assertInstanceOf(RedirectResponse::class, $redirect);
    }

    public function testPayPayDriver()
    {
        $this->mock(PayPay::class)
             ->shouldReceive('redirect')
             ->once()
             ->andReturn(redirect('test'));

        $driver = Payment::driver('paypay');
        $redirect = $driver->redirect();

        $this->assertInstanceOf(PaypayDriver::class, $driver);
        $this->assertInstanceOf(RedirectResponse::class, $redirect);
    }
}
