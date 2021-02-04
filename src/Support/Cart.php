<?php

namespace Revolution\Ordering\Support;

use Illuminate\Support\Collection;
use Revolution\Ordering\Facades\Menu;

class Cart
{
    /**
     * カートの商品ID配列からメニューに変換.
     *
     * @param  Collection|array|null  $items
     * @param  Collection|array|null  $menus
     *
     * @return Collection
     */
    public static function items($items = null, $menus = null): Collection
    {
        $menus = Collection::wrap($menus ?? Menu::get());

        return collect($items ?? session('cart', []))
            ->map(fn ($id) => $menus->firstWhere('id', $id));
    }
}
