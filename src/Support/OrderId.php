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
        $id = 0;

        while (is_numeric($id)) {
            $id = Str::random(1);
        }

        $id .= '-'.random_int(100, 999);

        return Str::upper($id);
    }
}
