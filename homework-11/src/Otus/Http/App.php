<?php

namespace Otus\Http;

use Dotenv\Dotenv;

class App
{
    private Router $router;

    public function __construct()
    {
        $this->loadEnvironment();
        $this->router = new Router();
    }

    public function run(): void
    {
        $response = $this->router->handle();
        $response->send();
    }

    private function loadEnvironment(): void
    {
        $dotenv = Dotenv::createImmutable($_SERVER['DOCUMENT_ROOT'] . '/../');
        $dotenv->load();
    }
}
