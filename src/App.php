<?php


namespace Src;

use Src\Http\Request;
use Src\Http\Router;

class App
{
    public function run() : string
    {
        $request = new Request($_GET, $_SERVER, $_SESSION);
        $router = new Router($request);

        return $router->getResponse();
    }
}