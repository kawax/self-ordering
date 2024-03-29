<?php

declare(strict_types=1);

namespace Revolution\Ordering\Contracts\Cart;

use Illuminate\Support\Collection;

interface CartFactory
{
    /**
     * @param  Collection|array|null  $items
     * @param  Collection|array|null  $menus
     * @return Collection
     */
    public function items($items = null, $menus = null): Collection;

    /**
     * @return array
     */
    public function all(): array;

    /**
     * @param  int|string  $id
     * @return void
     */
    public function add($id): void;

    /**
     * @param  int  $index
     * @return void
     */
    public function delete(int $index): void;

    /**
     * @return void
     */
    public function reset(): void;
}
