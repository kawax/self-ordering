<?php

declare(strict_types=1);

namespace Revolution\Ordering\Contracts\Menu;

use Illuminate\Support\Collection;

interface MenuDriver
{
    /**
     * @return array|Collection|mixed
     */
    public function get();
}
