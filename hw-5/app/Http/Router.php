<?php

namespace App\Http;

use App\Http\Controllers\IndexController;
use App\Http\Response\Response;

class Router
{
    public function resolve()
    {
        $urlParts = parse_url($_SERVER['REQUEST_URI']);

        if ($urlParts['path'] === '/') {
            $controller = new IndexController();
            $controller->index();
            return;
        }

        (new Response('', 400))->send();
    }
}
