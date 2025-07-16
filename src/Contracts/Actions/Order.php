<?php

declare(strict_types=1);

namespace Revolution\Ordering\Contracts\Actions;

interface Order
{
    public function order(?array $options = null): void;
}
