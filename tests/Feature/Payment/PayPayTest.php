<?php

namespace Tests\Feature\Payment;

use Illuminate\Http\RedirectResponse;
use Mockery as m;
use PayPay\OpenPaymentAPI\Client;
use PayPay\OpenPaymentAPI\Controller\Code;
use Revolution\Ordering\Payment\PayPay;
use Tests\TestCase;

class PayPayTest extends TestCase
{
    public function testPayPayFactory()
    {
        $this->assertInstanceOf(
            Client::class,
            app('ordering.paypay')
        );
    }

    public function testPayPayRedirect()
    {
        $this->withSession([
            'cart' => [
                1,
                2,
            ],
        ]);

        $client = m::mock(Client::class);

        $code = $this->mock(Code::class, function ($mock) {
            $mock->shouldReceive('createQRCode')
                 ->once()
                 ->andReturn(['data' => ['url' => 'http://localhost']]);
        });

        $client->code = $code;

        $this->instance('ordering.paypay', $client);

        $paypay = new PayPay();
        $redirect = $paypay->redirect();

        $this->assertInstanceOf(PayPay::class, $paypay);
        $this->assertInstanceOf(RedirectResponse::class, $redirect);
    }

    public function testPayPayPaymentDetails()
    {
        $client = m::mock(Client::class);

        $code = $this->mock(Code::class, function ($mock) {
            $mock->shouldReceive('getPaymentDetails')
                 ->once()
                 ->with('test')
                 ->andReturn(['data' => ['status' => 'COMPLETED']]);
        });

        $client->code = $code;

        $this->instance('ordering.paypay', $client);

        $paypay = new PayPay();
        $response = $paypay->getPaymentDetails('test');

        $this->assertEquals('COMPLETED', $response['status']);
    }

    public function testPayPayCheckCompleted()
    {
        $client = m::mock(Client::class);

        $code = $this->mock(Code::class, function ($mock) {
            $mock->shouldReceive('getPaymentDetails')
                 ->once()
                 ->with('test')
                 ->andReturn(['data' => ['status' => 'COMPLETED']]);
        });

        $client->code = $code;

        $this->instance('ordering.paypay', $client);

        $paypay = new PayPay();
        $response = $paypay->checkCompleted('test');

        $this->assertTrue($response);
    }
}
