<?php

declare(strict_types=1);

namespace Revolution\Ordering\Facades;

use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Facade;
use Revolution\Ordering\Contracts\Payment\PaymentDriver;
use Revolution\Ordering\Contracts\Payment\PaymentFactory;

/**
 * @method static PaymentDriver driver($driver)
 * @method static RedirectResponse redirect()
 */
class Payment extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return PaymentFactory::class;
    }
}
