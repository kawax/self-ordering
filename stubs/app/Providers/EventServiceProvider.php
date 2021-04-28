<?php

namespace App\Providers;

use App\Listeners\OrderEntryListener;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Revolution\Ordering\Events\OrderEntry;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        OrderEntry::class => [
            OrderEntryListener::class,
        ],
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
