<?php

declare(strict_types=1);

namespace Nlazarev\Hw6;

use Laminas\Diactoros\ServerRequestFactory;
use Laminas\HttpHandlerRunner\Emitter\SapiEmitter;
use Nlazarev\Hw6\Routes\Routes;

final class App
{
    public function run()
    {
        $request = ServerRequestFactory::fromGlobals(
            $_SERVER,
            $_GET,
            $_POST,
            $_COOKIE,
            $_FILES
        );
        
        Routes::getInstance()->initArticleRoutes();
        
        $response = Routes::getInstance()->getRouter()->dispatch($request);

        (new SapiEmitter)->emit($response);
    }
}
