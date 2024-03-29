<?php

declare(strict_types=1);

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

        try {
            $id .= '-'.random_int(100, 999);
        } catch (\Exception) {
            $id .= '-999';
        }

        return Str::upper($id);
    }
}
