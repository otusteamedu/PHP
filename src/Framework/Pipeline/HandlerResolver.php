<?php

namespace Framework\Pipeline;

use Psr\Container\ContainerInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;

use function Laminas\Stratigility\middleware;

class HandlerResolver
{
    /** @var \Psr\Container\ContainerInterface */
    private $container;

    /**
     * @param \Psr\Container\ContainerInterface $container
     */
    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }

    /**
     * @param mixed $handler
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

        if (is_callable($handler)) {
            return middleware(function (ServerRequestInterface $request) use ($handler) {
                return (new $handler())($request);
            });
        }

        if (is_string($handler)) {
            if ($this->container->has($handler)) {
                return $this->resolve($this->container->get($handler));
            }
        }

        if ($handler instanceof MiddlewareInterface) {
            return $handler;
        }

        throw new \InvalidArgumentException("Undefined a handler type {$handler}");
    }
}
