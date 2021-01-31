<?php

namespace Revolution\Ordering\Actions;

use Revolution\Ordering\Contracts\Actions\ResetCart;

class ResetCartAction implements ResetCart
{
    /**
     * @inheritDoc
     */
    public function reset(): void
    {
        session()->forget(['cart', 'memo']);
    }
}
