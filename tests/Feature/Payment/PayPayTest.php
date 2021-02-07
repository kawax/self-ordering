<?php

namespace Tests\Feature\Payment;

use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Arr;
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
                    ->andReturn(
                        Arr::add([], 'data.url', 'http://localhost')
                    );

        $paypay = new PayPay();
        $redirect = $paypay->redirect();

        $this->assertInstanceOf(PayPay::class, $paypay);
        $this->assertInstanceOf(RedirectResponse::class, $redirect);
    }

    public function testPayPayRedirectError()
    {
        Cart::add(1);

        PayPayClient::shouldReceive('code->createQRCode')
                    ->once()
                    ->andReturn([]);

        $paypay = new PayPay();
        $redirect = $paypay->redirect();

        $this->assertTrue($redirect->getSession()->has('payment_redirect_error'));
    }

    public function testPayPayPaymentDetails()
    {
        PayPayClient::shouldReceive('code->getPaymentDetails')
                    ->once()
                    ->with('test')
                    ->andReturn(
                        Arr::add([], 'data.status', 'COMPLETED')
                    );

        $paypay = new PayPay();
        $response = $paypay->getPaymentDetails('test');

        $this->assertSame('COMPLETED', Arr::get($response, 'data.status'));
    }

    public function testPayPayPaymentDetailsException()
    {
        PayPayClient::shouldReceive('code->getPaymentDetails')
                    ->once()
                    ->with('test')
                    ->andThrow(ClientControllerException::class);

        $paypay = new PayPay();
        $response = $paypay->getPaymentDetails('test');

        $this->assertSame('ERROR', Arr::get($response, 'data.status'));
    }
}
