<?php

namespace Revolution\Ordering\Contracts\Actions;

interface AddCart
{
    /**
     * @param  $id
     *
     * @return void
     */
    public function add($id): void;
}
