<?php
namespace Src;

use Src\Routes\Route;

/**
 * Initializes routes for api requests and run API
 *
 * @author <Denis Morozov>
 */
class App
{
    public function run(): void
    {
        $router = new Route();
        $router->init();
    }
}