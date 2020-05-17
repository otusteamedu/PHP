<?php

namespace Framework;

use App\Controller\BillingController;
use App\Controller\SiteController;
use Aura\Router\RouterContainer;
use Framework\Pipeline\EmptyHandler;
use Framework\Router\HandlerResolver;
use Laminas\Diactoros\Response;
use Laminas\Diactoros\ServerRequestFactory;
use Laminas\HttpHandlerRunner\Emitter\SapiEmitter;
use Laminas\Stratigility\Middleware\NotFoundHandler;
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
        $map->get('paid', '/paid', BillingController::class . '::paid');

        $matcher = $router->getMatcher();
        if (($route = $matcher->match($request)) !== false) {
            $resolver = new HandlerResolver();
            $pipeline->pipe($resolver->resolve($route->handler));
        }

        $pipeline->pipe(new NotFoundHandler(function () {
            return new Response();
        }));

        $response = $pipeline->process($request, new EmptyHandler());

        (new SapiEmitter())->emit($response);
    }
}
