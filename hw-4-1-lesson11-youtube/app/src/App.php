<?php

namespace App;

use Dotenv\Dotenv;
use Repetitor202\Application\Routers\Router;


class App
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