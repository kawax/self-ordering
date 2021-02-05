<?php

namespace Revolution\Ordering\Cart;

use Illuminate\Support\Arr;
use Illuminate\Support\Collection;
use Illuminate\Support\Traits\Macroable;
use Revolution\Ordering\Contracts\Cart\CartFactory;
use Revolution\Ordering\Facades\Menu;

class SessionCart implements CartFactory
{
    use Macroable;

    public const CART = 'cart';

    public const MEMO = 'memo';

    /**
     * カートの商品ID配列からメニューに変換.
     *
     * @param  Collection|array|null  $items
     * @param  Collection|array|null  $menus
     *
     * @return Collection
     */
    public function items($items = null, $menus = null): Collection
    {
        $menus = Collection::wrap($menus ?? Menu::get());

        return Collection::wrap($items ?? $this->all())
                         ->map(fn ($id) => $menus->firstWhere('id', $id));
    }

    /**
     * @return array
     */
    public function all(): array
    {
        return session(self::CART, []);
    }

    /**
     * @param  int|string  $id
     *
     * @return void
     */
    public function add($id): void
    {
        $items = $this->all();

        $items[] = $id;

        session([self::CART => $items]);
    }

    /**
     * @param  int  $index
     *
     * @return void
     */
    public function delete(int $index): void
    {
        $items = Arr::except($this->all(), [$index]);

        session([self::CART => $items]);
    }

    /**
     * @return void
     */
    public function reset(): void
    {
        session()->forget([self::CART, self::MEMO]);
    }
}
