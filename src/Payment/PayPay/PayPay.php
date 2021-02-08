<?php

namespace Revolution\Ordering\Payment\PayPay;

use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Illuminate\Support\Traits\Macroable;
use PayPay\OpenPaymentAPI\Controller\ClientControllerException;
use PayPay\OpenPaymentAPI\Models\CreateQrCodePayload;
use PayPay\OpenPaymentAPI\Models\ModelException;
use PayPay\OpenPaymentAPI\Models\OrderItem;
use Revolution\Ordering\Events\Payment\PayPayErrored;
use Revolution\Ordering\Events\Payment\PayPayRedirected;
use Revolution\Ordering\Facades\Cart;
use Revolution\PayPay\Facades\PayPay as PayPayClient;

class PayPay
{
    use Macroable;

    public const COMPLETED = 'COMPLETED';

    /**
     * @return RedirectResponse
     */
    public function redirect()
    {
        $response = rescue(fn () => PayPayClient::code()->createQRCode($this->payload()), []);

        if (Arr::has($response, 'data.url')) {
            PayPayRedirected::dispatch($response);

            return redirect()->away(Arr::get($response, 'data.url'));
        } else {
            PayPayErrored::dispatch($response);

            return back()->with(
                'payment_redirect_error',
                config('ordering.payment.paypay.redirect_error')
            );
        }
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
        $payload->setOrderItems($items->map([$this, 'createOrderItem'])->toArray());

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

        return (new CreateQrCodePayload())
            ->setMerchantPaymentId($merchantPaymentId)
            ->setRedirectType('WEB_LINK')
            ->setRedirectUrl(route('paypay.callback', ['payment' => $merchantPaymentId]))
            ->setRequestedAt()
            ->setCodeType();
    }

    /**
     * @param  array  $menu
     *
     * @return OrderItem
     * @throws ModelException
     */
    public function createOrderItem(array $menu): OrderItem
    {
        return (new OrderItem())
            ->setName(Str::limit(Arr::get($menu, 'name'), 150))
            ->setCategory(Str::limit(Arr::get($menu, 'category'), 255))
            ->setQuantity(1)
            ->setUnitPrice([
                'amount'   => (int) Arr::get($menu, 'price'),
                'currency' => config('paypay.currency', 'JPY'),
            ]);
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
