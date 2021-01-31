<?php

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
        info($event->table.' : '.$event->memo, $event->items);
    }
}
