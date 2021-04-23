<?php

declare(strict_types=1);

namespace Revolution\Ordering\Contracts\Actions;

interface ResetCart
{
    /**
     * @return void
     */
    public function reset(): void;
}
