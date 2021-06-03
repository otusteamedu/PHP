<?php

namespace App\Providers;

use Illuminate\Auth\Events\Registered;
use App\Events\BankStatementJobFinished;
use App\Listeners\BankStatementJobListener;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Event;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected array $listen = [
        Registered::class => [
            SendEmailVerificationNotification::class,
        ],
        BankStatementJobFinished::class => [
            BankStatementJobListener::class
        ]
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
