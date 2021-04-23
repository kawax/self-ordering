<?php

declare(strict_types=1);

namespace Revolution\Ordering\Contracts\Actions;

interface Order
{
    /**
     * @param  null|array  $options
     *
     * @return void
     */
    public function order(array $options = null): void;
}
