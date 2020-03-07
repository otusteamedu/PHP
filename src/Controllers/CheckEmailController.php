<?php

namespace Bjlag\Controllers;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class CheckEmailController
{
    public function process(ServerRequestInterface $request, array $args): ResponseInterface
    {
        return (new \Bjlag\Response(200, [], 'Check email'))
            ->withServerName($request)
            ->get();
    }
}
