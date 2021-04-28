<?php

declare(strict_types=1);

namespace App\Listeners;

use Revolution\Ordering\Events\OrderEntry;

class OrderEntryListener
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  OrderEntry  $event
     *
     * @return void
     */
    public function handle(OrderEntry $event)
    {
        info('Order ID : '.$event->order_id);
        info($event->table.' : '.$event->memo, $event->items);
        info('options', $event->options);
    }
}
