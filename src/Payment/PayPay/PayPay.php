<?php

namespace Revolution\Ordering\Payment\PayPay;

use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Illuminate\Support\Traits\Macroable;
use PayPay\OpenPaymentAPI\Controller\ClientControllerException;
use PayPay\OpenPaymentAPI\Models\CreateQrCodePayload;
use PayPay\OpenPaymentAPI\Models\ModelException;
use Revolution\Ordering\Events\Payment\PayPayErrored;
use Revolution\Ordering\Events\Payment\PayPayRedirected;
use Revolution\Ordering\Facades\Cart;
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
        $response = rescue([$this, 'createQRCode'], []);

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
     * @return array
     * @throws ClientControllerException
     * @throws ModelException
     */
    public function createQRCode(): array
    {
        return PayPayClient::code()->createQRCode($this->payload());
    }

    /**
     * @return CreateQrCodePayload
     * @throws ModelException
     */
    protected function payload(): CreateQrCodePayload
    {
        $items = Cart::items();

        $payload = $this->createQrCodePayload();

        $payload->setAmount([
            'amount'   => $items->sum('price'),
            'currency' => config('paypay.currency', 'JPY'),
        ]);

        // OrderItemsは省略可
        $payload->setOrderItems(
            $items->map(app(CreateOrderItem::class))->toArray()
        );

        //$payload->setOrderDescription('OrderDescription');

        return $payload;
    }

    /**
     * @return CreateQrCodePayload
     * @throws ModelException
     */
    protected function createQrCodePayload(): CreateQrCodePayload
    {
        $merchantPaymentId = Str::limit(app(MerchantPaymentId::class)->create(), 64);

        return app(CreateQrCodePayload::class)
            ->setMerchantPaymentId($merchantPaymentId)
            ->setRedirectType('WEB_LINK')
            ->setRedirectUrl(route('paypay.callback', ['payment' => $merchantPaymentId]))
            ->setRequestedAt()
            ->setCodeType();
    }

    /**
     * @param  string  $merchantPaymentId
     *
     * @return array
     */
    public function getPaymentDetails(string $merchantPaymentId): array
    {
        try {
            return PayPayClient::code()->getPaymentDetails($merchantPaymentId);
        } catch (ClientControllerException $e) {
            return Arr::add([], 'data.status', 'ERROR');
        }
    }
}
