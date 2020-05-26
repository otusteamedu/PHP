<?php

namespace Framework\Router;

use Psr\Http\Message\ServerRequestInterface;

interface Router
{
    /**
     * @param \Psr\Http\Message\ServerRequestInterface $request
     * @return \Framework\Router\Result
     * @throws \Framework\Router\Exception\RouteNotMatchedException
     */
    public function match(ServerRequestInterface $request): Result;
}
