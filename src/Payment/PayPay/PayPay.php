<?php

namespace Revolution\Ordering\Payment\PayPay;

use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Arr;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;
use PayPay\OpenPaymentAPI\Client;
use PayPay\OpenPaymentAPI\Controller\ClientControllerException;
use PayPay\OpenPaymentAPI\Models\CreateQrCodePayload;
use PayPay\OpenPaymentAPI\Models\ModelException;
use PayPay\OpenPaymentAPI\Models\OrderItem;
use Revolution\Ordering\Facades\Menu;

class PayPay
{
    public const COMPLETED = 'COMPLETED';

    /**
     * @return RedirectResponse
     * @throws ModelException
     * @throws ClientControllerException
     */
    public function redirect()
    {
        /**
         * @var Client $client
         */
        $client = app('ordering.paypay');

        $response = $client->code->createQRCode($this->payload());

        return redirect()->away(Arr::get($response, 'data.url'));
    }

    /**
     * @return CreateQrCodePayload
     * @throws ModelException
     */
    protected function payload(): CreateQrCodePayload
    {
        $payload = $this->createPayload();

        $menus = Collection::wrap(Menu::get());

        $items = collect(session('cart', []))
            ->map(fn ($id) => $menus->firstWhere('id', $id));

        $payload->setAmount([
            'amount'   => $items->sum('price'),
            'currency' => 'JPY',
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
        $merchantPaymentId = app(MerchantPaymentId::class)->create();

        return (new CreateQrCodePayload())
            ->setMerchantPaymentId(Str::limit($merchantPaymentId, 64))
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
                'currency' => 'JPY',
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
        /**
         * @var Client $client
         */
        $client = app('ordering.paypay');

        $response = $client->code->getPaymentDetails($payment_id);

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
        return Arr::get($this->getPaymentDetails($payment_id), 'status') === 'COMPLETED';
    }
}
