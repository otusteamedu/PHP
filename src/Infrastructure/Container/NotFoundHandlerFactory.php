<?php

namespace Infrastructure\Container;

use Laminas\Diactoros\Response;
use Laminas\Stratigility\Middleware\NotFoundHandler;

class NotFoundHandlerFactory
{
    public function __invoke()
    {
        return new NotFoundHandler(function () {
            return new Response();
        });
    }
}
