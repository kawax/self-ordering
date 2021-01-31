<?php

namespace Revolution\Ordering\Events;

use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class OrderEntry
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $items;

    public $table;

    public $memo;

    /**
     * @param  $items
     * @param  $table
     * @param  $memo
     */
    public function __construct($items, $table, $memo)
    {
        $this->items = $items;
        $this->table = $table;
        $this->memo = $memo;
    }
}
