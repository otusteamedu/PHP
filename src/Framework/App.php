<?php

namespace Framework;

use App\Controller\SiteController;
use Aura\Router\RouterContainer;
use Framework\Middleware\ActionResolverMiddleware;
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

        ###

        $router = new RouterContainer();
        $map = $router->getMap();
        $map->get('home', '/', SiteController::class);

        $matcher = $router->getMatcher();
        if (($route = $matcher->match($request)) !== false) {
            $pipeline->pipe(new ActionResolverMiddleware(new $route->handler));
        }

        $response = $pipeline->process($request, new EmptyHandler());

        (new SapiEmitter())->emit($response);
    }
}
