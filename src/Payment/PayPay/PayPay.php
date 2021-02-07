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
use Revolution\Ordering\Facades\Cart;
use Revolution\PayPay\Facades\PayPay as PayPayClient;

class PayPay
{
    use Macroable;

    public const COMPLETED = 'COMPLETED';

    /**
     * @return RedirectResponse
     * @throws ModelException
     * @throws ClientControllerException
     */
    public function redirect()
    {
        $response = PayPayClient::code()->createQRCode($this->payload());

        return redirect()->away(Arr::get($response, 'data.url'));
    }

    /**
     * @return CreateQrCodePayload
     * @throws ModelException
     */
    protected function payload(): CreateQrCodePayload
    {
        $items = Cart::items();

        $payload = $this->createPayload();

        $payload->setAmount([
            'amount'   => $items->sum('price'),
            'currency' => config('paypay.currency', 'JPY'),
        ]);

        $payload->setOrderItems($items->map([$this, 'createOrderItem'])->toArray());

        //$payload->setOrderDescription('OrderDescription');

        return $payload;
    }

    /**
     * @return CreateQrCodePayload
     * @throws ModelException
     */
    protected function createPayload(): CreateQrCodePayload
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
     * @param  string  $payment_id
     *
     * @return array
     */
    public function getPaymentDetails(string $payment_id): array
    {
        try {
            $response = PayPayClient::code()->getPaymentDetails($payment_id);
        } catch (ClientControllerException $e) {
            Arr::set($response, 'data.status', 'ERROR');
        }

        return $response['data'];
    }
}
