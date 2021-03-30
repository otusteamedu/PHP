<?php

namespace App\Core;

use App\Services\ServiceProvider\AppServiceProvider;
use App\Services\ServiceContainer\AppServiceContainer;

class App
{
    /**
     * @return mixed
     */
    public function run()
    {
        $serviceContainer = AppServiceContainer::getInstance();
        $serviceContainer->boot();

        $serviceProvider = AppServiceProvider::getInstance();
        $serviceProvider->boot();

        $request = Request::getInstance();
        $router = new Router($request);
        $response = $router->getResponse();

        return $response();
    }
}