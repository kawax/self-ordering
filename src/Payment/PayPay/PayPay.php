<?php

namespace Revolution\Ordering\Payment\PayPay;

use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use PayPay\OpenPaymentAPI\Client;
use PayPay\OpenPaymentAPI\Controller\ClientControllerException;
use PayPay\OpenPaymentAPI\Models\CreateQrCodePayload;
use PayPay\OpenPaymentAPI\Models\ModelException;
use PayPay\OpenPaymentAPI\Models\OrderItem;
use Revolution\Ordering\Facades\Cart;

class PayPay
{
    public const COMPLETED = 'COMPLETED';

    /**
     * @var Client
     */
    protected Client $client;

    public function __construct()
    {
        $this->client = app('ordering.paypay');
    }

    /**
     * @return RedirectResponse
     * @throws ModelException
     * @throws ClientControllerException
     */
    public function redirect()
    {
        $response = $this->client->code->createQRCode($this->payload());

        return redirect()->away(Arr::get($response, 'data.url'));
    }

    /**
     * @return CreateQrCodePayload
     * @throws ModelException
     */
    protected function payload(): CreateQrCodePayload
    {
        $payload = $this->createPayload();

        $items = Cart::items();

        $payload->setAmount([
            'amount'   => $items->sum('price'),
            'currency' => config('ordering.payment.paypay.currency', 'JPY'),
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
                'amount'   => Arr::get($menu, 'price'),
                'currency' => config('ordering.payment.paypay.currency', 'JPY'),
            ]);
    }

    /**
     * @param  string  $payment_id
     *
     * @return array
     * @throws ClientControllerException
     */
    public function getPaymentDetails(string $payment_id): array
    {
        $response = $this->client->code->getPaymentDetails($payment_id);

        return $response['data'];
    }

    /**
     * @param  string  $payment_id
     *
     * @return bool
     * @throws ClientControllerException
     */
    public function checkCompleted(string $payment_id): bool
    {
        return Arr::get($this->getPaymentDetails($payment_id), 'status') === self::COMPLETED;
    }
}
