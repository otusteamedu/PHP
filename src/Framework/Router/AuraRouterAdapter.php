<?php

namespace Framework\Router;

use Aura\Router\RouterContainer;
use Framework\Router\Exception\RouteNotMatchedException;
use Psr\Http\Message\ServerRequestInterface;

class AuraRouterAdapter implements Router
{
    /** @var \Aura\Router\RouterContainer */
    private $aura;

    /**
     * @param \Aura\Router\RouterContainer $aura
     */
    public function __construct(RouterContainer $aura)
    {
        $this->aura = $aura;
    }

    /**
     * @param \Psr\Http\Message\ServerRequestInterface $request
     * @return \Framework\Router\Result
     * @throws \Framework\Router\Exception\RouteNotMatchedException
     */
    public function match(ServerRequestInterface $request): Result
    {
        $matcher = $this->aura->getMatcher();
        if (($route = $matcher->match($request)) !== false) {
            return new Result($route->name, $route->handler, $route->attributes);
        }

        throw new RouteNotMatchedException();
    }
}
