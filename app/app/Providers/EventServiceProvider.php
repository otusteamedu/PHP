<?php

namespace App\Providers;

use Laravel\Lumen\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        \App\Events\ExampleEvent::class => [
            \App\Listeners\ExampleListener::class,
        ],
        \App\Events\OrderCreated::class => [
            \App\Listeners\OrderCreatedListener::class,
        ],
        \App\Events\OrderDeleted::class => [
            \App\Listeners\OrderDeletedListener::class,
        ],
        \App\Events\OrderUpdated::class => [
            \App\Listeners\OrderUpdatedListener::class,
        ],
    ];
}
