<?php

namespace Revolution\Ordering\Payment\PayPay;

use Illuminate\Support\Arr;
use Illuminate\Support\Traits\Macroable;
use Revolution\Ordering\Events\Payment\PayPayErrored;
use Revolution\Ordering\Events\Payment\PayPayRedirected;
use Revolution\PayPay\Facades\PayPay as PayPayClient;

class PayPay
{
    use Macroable;

    public const COMPLETED = 'COMPLETED';

    /**
     * @return mixed
     */
    public function redirect()
    {
        $response = rescue(app(CreateQrCode::class), []);

        if (Arr::has($response, 'data.url')) {
            PayPayRedirected::dispatch($response);

            return redirect()->away(Arr::get($response, 'data.url'));
        }

        PayPayErrored::dispatch($response);

        return back()->with(
            'payment_redirect_error',
            config('ordering.payment.paypay.redirect_error')
        );
    }

    /**
     * @param  string  $merchantPaymentId
     *
     * @return array
     */
    public function getPaymentDetails(string $merchantPaymentId): array
    {
        return rescue(
            fn () => PayPayClient::code()->getPaymentDetails($merchantPaymentId),
            Arr::add([], 'data.status', 'ERROR')
        );
    }
}
