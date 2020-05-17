<?php

namespace Framework;

use App\Middleware\PhpInfoMiddleware;
use Framework\Pipeline\EmptyHandler;
use Laminas\Diactoros\ServerRequestFactory;
use Laminas\HttpHandlerRunner\Emitter\SapiEmitter;
use Laminas\Stratigility\MiddlewarePipe;

class App
{
    public function run()
    {
        $request = ServerRequestFactory::fromGlobals();

        $pipeline = new MiddlewarePipe();
        $pipeline->pipe(new PhpInfoMiddleware());
        $response = $pipeline->process($request, new EmptyHandler());

        (new SapiEmitter())->emit($response);
    }
}
