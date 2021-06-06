<?php

namespace App\Services\ServiceProvider;

use App\Services\RabbitMQ\RabbitMQServiceProvider;

class AppServiceProvider
{
    private static ?self $instance = null;

    private function __construct()
    {}

    public static function getInstance(): self
    {
        if(is_null(self::$instance)){
            self::$instance = new self;
        }

        return self::$instance;
    }

    public function boot(): void
    {
        (new RabbitMQServiceProvider())->boot();
    }
}