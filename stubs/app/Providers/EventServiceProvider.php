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
     */
    public function boot(): void
    {
        //
    }

    /**
     * Determine if events and listeners should be automatically discovered.
     */
    public function shouldDiscoverEvents(): bool
    {
        return false;
    }
}
