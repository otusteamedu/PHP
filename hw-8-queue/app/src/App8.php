<?php

namespace App;

use Dotenv\Dotenv;
use Repetitor8\Application\Routers\Router;

class App8
{
    public function __construct()
    {
        $dotenv = Dotenv::createImmutable(__DIR__ . '/..');
        $dotenv->load();
    }

    public function run(): void
    {
        Router::run();
    }
}