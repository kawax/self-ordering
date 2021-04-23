<?php

declare(strict_types=1);

namespace Revolution\Ordering\Payment\PayPay;

use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use PayPay\OpenPaymentAPI\Models\ModelException;
use PayPay\OpenPaymentAPI\Models\OrderItem;

class CreateOrderItem
{
    /**
     * @param  array  $menu
     *
     * @return OrderItem
     * @throws ModelException
     */
    public function __invoke(array $menu): OrderItem
    {
        return app(OrderItem::class)
            ->setName(Str::limit(Arr::get($menu, 'name'), 150))
            ->setCategory(Str::limit((string) Arr::get($menu, 'category'), 255))
            ->setProductId(Str::limit((string) Arr::get($menu, 'id'), 255))
            ->setQuantity(1)
            ->setUnitPrice([
                'amount'   => (int) Arr::get($menu, 'price'),
                'currency' => config('paypay.currency', 'JPY'),
            ]);
    }
}
