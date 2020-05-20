<?php

namespace unit\Framework\Pipeline;

use Framework\Pipeline\HandlerResolver;
use Framework\Pipeline\UndefinedHandlerException;
use Laminas\Diactoros\Response;
use Laminas\Diactoros\ServerRequestFactory;
use Laminas\ServiceManager\AbstractFactory\ReflectionBasedAbstractFactory;
use Laminas\ServiceManager\ServiceManager;
use PHPUnit\Framework\TestCase;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;

class HandlerResolverTest extends TestCase
{
    public function testResolveController()
    {
        $container = new ServiceManager();
        $resolver = new HandlerResolver($container);

        /** @var \Psr\Http\Message\ServerRequestInterface $request */
        $request = ServerRequestFactory::fromGlobals();
        $middleware = $resolver->resolve(TestController::class . '::test');
        $response = $middleware->process($request, new Handler());

        self::assertSame('test', $response->getBody()->getContents());
        self::assertSame(200, $response->getStatusCode());
    }

    public function testResolveCallable()
    {
        $container = new ServiceManager();
        $container->addAbstractFactory(ReflectionBasedAbstractFactory::class);
        $resolver = new HandlerResolver($container);

        /** @var \Psr\Http\Message\ServerRequestInterface $request */
        $request = ServerRequestFactory::fromGlobals();
        $middleware = $resolver->resolve(TestInvokeController::class);
        $response = $middleware->process($request, new Handler());

        self::assertSame('test', $response->getBody()->getContents());
        self::assertSame(200, $response->getStatusCode());
    }

    public function testResolveMiddleware()
    {
        $container = new ServiceManager();
        $container->addAbstractFactory(ReflectionBasedAbstractFactory::class);
        $resolver = new HandlerResolver($container);

        /** @var \Psr\Http\Message\ServerRequestInterface $request */
        $request = ServerRequestFactory::fromGlobals();
        $middleware = $resolver->resolve(TestMiddleware::class);
        $response = $middleware->process($request, new Handler());

        self::assertSame('test', $response->getBody()->getContents());
        self::assertSame(200, $response->getStatusCode());
    }

    public function testResolveUndefinedHandler()
    {
        $container = new ServiceManager();
        $resolver = new HandlerResolver($container);

        self::expectException(UndefinedHandlerException::class);

        $resolver->resolve('undefined handler');
    }
}

### For tests

class TestController
{
    public function testAction(ServerRequestInterface $request): ResponseInterface
    {
        return new Response\HtmlResponse('test', 200);
    }
}

class TestInvokeController
{
    public function __invoke()
    {
        return new Response\HtmlResponse('test', 200);
    }
}

class TestMiddleware implements MiddlewareInterface
{
    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        return new Response\HtmlResponse('test', 200);
    }
}

class Handler implements RequestHandlerInterface
{
    public function handle(ServerRequestInterface $request): \Psr\Http\Message\ResponseInterface
    {
        return new Response();
    }
}
