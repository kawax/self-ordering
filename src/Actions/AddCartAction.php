<?php

namespace Revolution\Ordering\Actions;

use Revolution\Ordering\Contracts\Actions\AddCart;

class AddCartAction implements AddCart
{
    /**
     * @inheritDoc
     */
    public function add($id): void
    {
        $cart = session('cart', []);

        $cart[] = $id;

        session(['cart' => $cart]);
    }
}
