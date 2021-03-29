<?php

namespace App\Services\ServiceProvider;

use App\Services\ElasticSearch\ElasticSearchServiceProvider;

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
        (new ElasticSearchServiceProvider())->boot();
    }
}