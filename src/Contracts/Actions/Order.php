<?php

namespace Revolution\Ordering\Contracts\Actions;

interface Order
{
    /**
     * @param  null|mixed  $options
     *
     * @return mixed|void
     */
    public function order($options = null);
}
