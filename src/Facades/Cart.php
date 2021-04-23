<?php

declare(strict_types=1);

namespace Revolution\Ordering\Facades;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Facade;
use Revolution\Ordering\Contracts\Cart\CartFactory;

/**
 * @method static Collection items($items = null, $menus = null) カートの商品ID配列からメニューに変換されたデータ
 * @method static array all() 商品IDの配列
 * @method static void add($id)
 * @method static void delete(int $index)
 * @method static void reset()
 */
class Cart extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return CartFactory::class;
    }
}
