<?php

namespace Framework;

use App\Controller\BillingController;
use App\Controller\SiteController;
use Aura\Router\RouterContainer;
use Framework\Pipeline\EmptyHandler;
use Laminas\Diactoros\Response;
use Laminas\Diactoros\ServerRequestFactory;
use Laminas\HttpHandlerRunner\Emitter\SapiEmitter;
use Laminas\Stratigility\Middleware\NotFoundHandler;
use Laminas\Stratigility\MiddlewarePipe;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;

use function Laminas\Stratigility\middleware;

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
            $handler = $route->handler;
            $middleware = null;

            if (is_string($handler)) {
                $middleware = middleware(function (ServerRequestInterface $request) use ($handler) {
                    return (new $handler())($request);
                });
            }

            if (is_string($handler) && ($pos = strpos($handler, '::')) !== false) {
                $middleware = middleware(function (ServerRequestInterface $request) use ($handler, $pos) {
                    $class = substr($handler, 0, $pos);
                    $action = substr($handler, $pos + 2) . 'Action';
                    $instance = new $class();

                    return $instance->{$action}($request);
                });
            }

            if ($middleware instanceof MiddlewareInterface) {
                $pipeline->pipe($middleware);
            }
        }

        $pipeline->pipe(new NotFoundHandler(function () {
            return new Response();
        }));

        $response = $pipeline->process($request, new EmptyHandler());

        (new SapiEmitter())->emit($response);
    }
}
