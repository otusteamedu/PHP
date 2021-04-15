<?php

namespace Src;

use Src\Routes\Route;

/**
 * Class App
 *
 * @package Src\App
 */
class App
{
    public function run(): void
    {
        $router = new Route();
        $router->init();
    }
}