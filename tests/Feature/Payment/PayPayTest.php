<?php

namespace Tests\Feature\Payment;

use Illuminate\Http\RedirectResponse;
use PayPay\OpenPaymentAPI\Controller\ClientControllerException;
use Revolution\Ordering\Facades\Cart;
use Revolution\Ordering\Payment\PayPay\PayPay;
use Revolution\PayPay\Facades\PayPay as PayPayClient;
use Tests\TestCase;

class PayPayTest extends TestCase
{
    public function testPayPayRedirect()
    {
        Cart::add(1);

        PayPayClient::shouldReceive('code->createQRCode')
                    ->once()
                    ->andReturn(['data' => ['url' => 'http://localhost']]);

        $paypay = new PayPay();
        $redirect = $paypay->redirect();

        $this->assertInstanceOf(PayPay::class, $paypay);
        $this->assertInstanceOf(RedirectResponse::class, $redirect);
    }

    public function testPayPayPaymentDetails()
    {
        PayPayClient::shouldReceive('code->getPaymentDetails')
                    ->once()
                    ->with('test')
                    ->andReturn(['data' => ['status' => 'COMPLETED']]);

        $paypay = new PayPay();
        $response = $paypay->getPaymentDetails('test');

        $this->assertSame('COMPLETED', $response['status']);
    }

    public function testPayPayPaymentDetailsException()
    {
        PayPayClient::shouldReceive('code->getPaymentDetails')
                    ->once()
                    ->with('test')
                    ->andThrow(ClientControllerException::class);

        $paypay = new PayPay();
        $response = $paypay->getPaymentDetails('test');

        $this->assertSame('ERROR', $response['status']);
    }
}
