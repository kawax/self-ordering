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

    public $options;

    /**
     * @param  $items
     * @param  $table
     * @param  $memo
     * @param  $options
     */
    public function __construct($items, $table, $memo, $options)
    {
        $this->items = $items;
        $this->table = $table;
        $this->memo = $memo;
        $this->options = $options;
    }
}
