<?php

namespace Revolution\Ordering\Actions;

use Revolution\Ordering\Contracts\Actions\AddCart;
use Revolution\Ordering\Facades\Cart;

class AddCartAction implements AddCart
{
    /**
     * @inheritDoc
     */
    public function add($id): void
    {
        Cart::add($id);
    }
}
