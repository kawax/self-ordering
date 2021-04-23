<?php

declare(strict_types=1);

namespace Revolution\Ordering\Contracts\Actions;

interface AddHistory
{
    /**
     * @param  array  $history
     *
     * @return void
     */
    public function add(array $history): void;
}
