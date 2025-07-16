<?php

declare(strict_types=1);

namespace Revolution\Ordering\Contracts\Cart;

use Illuminate\Support\Collection;

interface CartFactory
{
    /**
     * @param  Collection|array|null  $items
     * @param  Collection|array|null  $menus
     */
    public function items($items = null, $menus = null): Collection;

    public function all(): array;

    /**
     * @param  int|string  $id
     */
    public function add($id): void;

    public function delete(int $index): void;

    public function reset(): void;
}
