<?php

namespace App;

use FastRoute\Dispatcher;
use FastRoute\RouteCollector;

use function FastRoute\cachedDispatcher;

final class Router
{
    private static function routes(): Dispatcher
    {
        return cachedDispatcher(
            static function (RouteCollector $r) {
                $r->addRoute('GET', '/', [Action\Example::class, 'get']);
            },
            [
                'cacheFile' => '/tmp/app.route.cache',
                'cacheDisabled' => 'dev' === App::getEnv(),
            ]
        );
    }

    /**
     * Strip query string (?foo=bar) and decode URI
     * @return string
     */
    private static function decodeUri(): string
    {
        $uri = $_SERVER['REQUEST_URI'];
        if (false !== $pos = strpos($uri, '?')) {
            $uri = substr($uri, 0, $pos);
        }
        return rawurldecode($uri);
    }

    public static function dispatch(): void
    {
        $routeInfo = self::routes()->dispatch($_SERVER['REQUEST_METHOD'], self::decodeUri());
        switch ($routeInfo[0]) {
            case Dispatcher::NOT_FOUND:
                http_response_code(404);
                break;
            case Dispatcher::METHOD_NOT_ALLOWED:
                http_response_code(405);
                break;
            case Dispatcher::FOUND:
                [, $handler, $vars] = $routeInfo;
                /** @var \App\Responce */
                $responce = call_user_func_array($handler, $vars);
                $responce->emit();
                break;
        }
    }
}
