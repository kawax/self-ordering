<?php

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
