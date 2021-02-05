<?php

namespace Revolution\Ordering\Providers\Concerns;

use Revolution\Ordering\Payment\PayPay\PayPayClientFactory;

trait WithPayPay
{
    protected function registerPayPay()
    {
        $this->app->singleton('ordering.paypay', fn ($app) => $app->make(PayPayClientFactory::class)());
    }
}
