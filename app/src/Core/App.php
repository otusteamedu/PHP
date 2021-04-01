<?php

namespace App\Core;

use App\Services\ServiceProvider\AppServiceProvider;
use App\Services\ServiceContainer\AppServiceContainer;

class App
{
    /**
     * @return string
     */
    public function run() : string
    {
        $serviceContainer = AppServiceContainer::getInstance();
        $serviceContainer->boot();

        $serviceProvider = AppServiceProvider::getInstance();
        $serviceProvider->boot();

        $request = Request::getInstance();
        $router = new Router($request);

        return $router->getResponse();
    }
}