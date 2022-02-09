<?php

declare(strict_types=1);

namespace Revolution\Ordering\Events;

use Illuminate\Foundation\Events\Dispatchable;

class OrderEntry
{
    use Dispatchable;

    /**
     * @param  string  $order_id
     * @param  array|null  $items
     * @param  string|null  $table
     * @param  string|null  $memo
     * @param  array|null  $options
     */
    public function __construct(
        public string $order_id,//注文ID
        public ?array $items,//詳細を含む商品データ
        public ?string $table,//テーブル番号
        public ?string $memo,//追加メモ
        public ?array $options//オプションデータ
    ) {
        //
    }
}
