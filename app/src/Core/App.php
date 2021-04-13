<?php

namespace App\Core;

use App\Services\ServiceProvider\AppServiceProvider;
use App\Services\ServiceContainer\AppServiceContainer;

class App
{
    /**
     * @param array $argv
     * @return string
     */
    public function run(array $argv = []) : string
    {
        $serviceContainer = AppServiceContainer::getInstance();
        $serviceContainer->boot();

        $serviceProvider = AppServiceProvider::getInstance();
        $serviceProvider->boot();

        if($this->isConsoleRequest()){
            return $this->runConsoleRequest($argv);
        }

        return $this->runWebRequest();
    }

    private function runConsoleRequest(array $argv) : string
    {
        $console = new Console($argv);
        return $console->getResponse();
    }

    private function runWebRequest() : string
    {
        $request = Request::getInstance();
        $router = new Router($request);

        return $router->getResponse();
    }

    private function isConsoleRequest() : bool
    {
        return  PHP_SAPI === 'cli' ;
    }
}