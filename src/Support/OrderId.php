<?php

namespace Revolution\Ordering\Support;

use Illuminate\Support\Str;

class OrderId
{
    /**
     * @return string
     */
    public function create(): string
    {
        return Str::upper(Str::random(4));
    }
}
