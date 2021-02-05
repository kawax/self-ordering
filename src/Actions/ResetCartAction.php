<?php

namespace Revolution\Ordering\Actions;

use Revolution\Ordering\Contracts\Actions\ResetCart;
use Revolution\Ordering\Facades\Cart;

class ResetCartAction implements ResetCart
{
    /**
     * @inheritDoc
     */
    public function reset(): void
    {
        Cart::reset();
    }
}
