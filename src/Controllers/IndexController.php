<?php

namespace Bjlag\Controllers;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class IndexController
{
    public function process(ServerRequestInterface $request, array $args): ResponseInterface
    {
        $body = "
            Home Work 7<br>
            Валидация емейла: /check-email/checking@email.ru
        ";

        return (new \Bjlag\Response(200, [], $body))
            ->withServerName($request)
            ->get();
    }
}
