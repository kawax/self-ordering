<?php

namespace Revolution\Ordering\Events;

use Illuminate\Foundation\Events\Dispatchable;

class OrderEntry
{
    use Dispatchable;

    /**
     * 詳細を含む商品データ.
     *
     * @var array|null
     */
    public ?array $items;

    /**
     * テーブル番号.
     *
     * @var string|null
     */
    public ?string $table;

    /**
     * 追加メモ.
     *
     * @var string|null
     */
    public ?string $memo;

    /**
     * オプションデータ.
     *
     * @var array|null
     */
    public ?array $options;

    /**
     * @param  array|null  $items
     * @param  string|null  $table
     * @param  string|null  $memo
     * @param  array|null  $options
     */
    public function __construct(?array $items, ?string $table, ?string $memo, ?array $options)
    {
        $this->items = $items;
        $this->table = $table;
        $this->memo = $memo;
        $this->options = $options;
    }
}
