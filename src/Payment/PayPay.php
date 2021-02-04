<?php

namespace Revolution\Ordering\Payment;

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
        $merchantPaymentId = Str::random(40);

        $payload = new CreateQrCodePayload();
        $payload->setMerchantPaymentId($merchantPaymentId);
        $payload->setRequestedAt();
        $payload->setCodeType();

        $menus = Collection::wrap(Menu::get());

        $items = collect(session('cart', []))
            ->map(fn ($id) => $menus->firstWhere('id', $id));

        $OrderItems = $items->map(fn ($menu) => (new OrderItem())
            ->setName(Arr::get($menu, 'name'))
            ->setCategory(Arr::get($menu, 'category'))
            ->setQuantity(1)
            ->setUnitPrice(['amount' => Arr::get($menu, 'price'), 'currency' => 'JPY']))->toArray();

        $payload->setOrderItems($OrderItems);

        $amount = [
            'amount'   => $items->sum('price'),
            'currency' => 'JPY',
        ];
        $payload->setAmount($amount);

        //$payload->setOrderDescription('OrderDescription');

        $payload->setRedirectType('WEB_LINK');
        $payload->setRedirectUrl(route('paypay.callback', ['payment' => $merchantPaymentId]));

        return $payload;
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
