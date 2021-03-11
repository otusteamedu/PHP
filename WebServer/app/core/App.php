<?php

namespace Core;

class App
{
    public function run(): void
    {
        $request = Request::getInstance();
        $router = new Router($request);
        $response = $router->getResponse();

        echo $response();
    }
}