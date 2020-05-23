<?php

namespace Test\unit\Framework\Router;

use Aura\Router\RouterContainer;
use Framework\Router\AuraRouterAdapter;
use Framework\Router\Exception\RouteNotMatchedException;
use Framework\Router\Result;
use Laminas\Diactoros\ServerRequestFactory;
use Laminas\Diactoros\Uri;
use PHPUnit\Framework\TestCase;

class AuraRouterAdapterTest extends TestCase
{
    public function testMatchResult()
    {
        $aura = new RouterContainer();
        $map = $aura->getMap();
        $map->get($name = 'test', '/test', $callback = function () {});

        /** @var \Psr\Http\Message\ServerRequestInterface $request */
        $request = ServerRequestFactory::fromGlobals();
        $request = $request->withMethod('GET');
        $request = $request->withUri(new Uri('http://localhost/test'));

        $router = new AuraRouterAdapter($aura);
        $result = $router->match($request);

        self::assertInstanceOf(Result::class, $result, 'Result of work should be class instance Result');
    }

    public function testMatchRouteName()
    {
        $aura = new RouterContainer();
        $map = $aura->getMap();
        $map->get($name = 'test', '/test', $callback = function () {});

        /** @var \Psr\Http\Message\ServerRequestInterface $request */
        $request = ServerRequestFactory::fromGlobals();
        $request = $request->withMethod('GET');
        $request = $request->withUri(new Uri('http://localhost/test'));

        $router = new AuraRouterAdapter($aura);
        $result = $router->match($request);

        self::assertSame($name, $result->getName(), 'Name of route should be "'. $name .'"');
    }

    public function testMatchHandler()
    {
        $aura = new RouterContainer();
        $map = $aura->getMap();
        $map->get($name = 'test', '/test', $callback = function () {});

        /** @var \Psr\Http\Message\ServerRequestInterface $request */
        $request = ServerRequestFactory::fromGlobals();
        $request = $request->withMethod('GET');
        $request = $request->withUri(new Uri('http://localhost/test'));

        $router = new AuraRouterAdapter($aura);
        $result = $router->match($request);

        self::assertSame($callback, $result->getHandler(), "Not been received a handler");
    }

    public function testMatchAttributes()
    {
        $aura = new RouterContainer();
        $map = $aura->getMap();
        $map->get($name = 'test', '/test/{id}', $callback = function () {})->tokens(['id' => '\d+']);

        /** @var \Psr\Http\Message\ServerRequestInterface $request */
        $request = ServerRequestFactory::fromGlobals();
        $request = $request->withMethod('GET');
        $request = $request->withUri(new Uri('http://localhost/test/1'));

        $router = new AuraRouterAdapter($aura);
        $result = $router->match($request);

        self::assertSame('1', $result->getArgs()['id'], 'Should be received argument ID');
    }

    public function testMatchRouteNotFound()
    {
        $aura = new RouterContainer();

        /** @var \Psr\Http\Message\ServerRequestInterface $request */
        $request = ServerRequestFactory::fromGlobals();
        $request = $request->withMethod('GET');
        $request = $request->withUri(new Uri('http://localhost/test'));

        self::expectException(RouteNotMatchedException::class);

        $router = new AuraRouterAdapter($aura);
        $router->match($request);
    }
}
