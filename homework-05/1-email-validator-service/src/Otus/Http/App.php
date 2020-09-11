<?php

namespace Otus\Http;

class App
{
    private Router $router;

    public function __construct()
    {
        $this->router = new Router();
    }

    public function run(): void
    {
        $response = $this->router->handle();
        $response->send();
    }
}
