<?php

namespace App\Listeners;

use Revolution\Ordering\Events\OrderEntry;

class OrderEntryListener
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(OrderEntry $event): void
    {
        info('Order ID : '.$event->order_id);
        info($event->table.' : '.$event->memo, $event->items);
        info('options', $event->options);
    }
}
