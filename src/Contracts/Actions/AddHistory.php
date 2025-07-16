<?php

declare(strict_types=1);

namespace Revolution\Ordering\Contracts\Actions;

interface AddHistory
{
    public function add(array $history): void;
}
