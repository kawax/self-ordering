<?php

declare(strict_types=1);

namespace Revolution\Ordering\Contracts\Actions;

interface AddCart
{
    /**
     * @param  string|int  $id
     *
     * @return void
     */
    public function add($id): void;
}
