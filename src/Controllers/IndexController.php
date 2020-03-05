<?php

namespace App\Controllers;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class IndexController
{
    public function process(ServerRequestInterface $request): ResponseInterface
    {
        return new \Nyholm\Psr7\Response(200, [], 'Index page');
    }
}
