<?php

namespace Framework\Router;

use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;

use function Laminas\Stratigility\middleware;

class HandlerResolver
{
    /**
     * @param $handler
     * @return \Psr\Http\Server\MiddlewareInterface
     */
    public function resolve($handler): MiddlewareInterface
    {
        if (is_string($handler) && ($pos = strpos($handler, '::')) !== false) {
            return middleware(function (ServerRequestInterface $request) use ($handler, $pos) {
                $class = substr($handler, 0, $pos);
                $action = substr($handler, $pos + 2) . 'Action';
                $instance = new $class();

                return $instance->{$action}($request);
            });
        }

        if (is_string($handler)) {
            return middleware(function (ServerRequestInterface $request) use ($handler) {
                return (new $handler())($request);
            });
        }

        throw new \InvalidArgumentException("Undefined a handler type {$handler}");
    }
}
