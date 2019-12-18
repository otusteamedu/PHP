<?php
declare(strict_types=1);

use Checkers\BracketsChecker;
use DI\ContainerBuilder;
use Checkers\CheckerResponser;
use FastRoute\RouteCollector;
use Middlewares\FastRoute;
use Middlewares\RequestHandler;
use Narrowspark\HttpEmitter\SapiEmitter;
use Relay\Relay;
use Zend\Diactoros\Response;
use Zend\Diactoros\ServerRequestFactory;
use function DI\create;
use function DI\get;
use function FastRoute\simpleDispatcher;

require_once dirname(__DIR__) . '/vendor/autoload.php';

$containerBuilder = new ContainerBuilder();
$containerBuilder->useAutowiring(false);
$containerBuilder->useAnnotations(false);
$containerBuilder->addDefinitions([
    CheckerResponser::class => create(CheckerResponser::class)
        ->constructor(get('Response'), new BracketsChecker()),
    'Response' => function() {
        return new Response();
    },
]);
/** @noinspection PhpUnhandledExceptionInspection */
$container = $containerBuilder->build();

$routes = simpleDispatcher(function (RouteCollector $r) {
    $r->get('/', CheckerResponser::class);
    $r->post('/', CheckerResponser::class);
});

$middlewareQueue[] = new FastRoute($routes);
$middlewareQueue[] = new RequestHandler($container);

/** @noinspection PhpUnhandledExceptionInspection */
$requestHandler = new Relay($middlewareQueue);
$response = $requestHandler->handle(ServerRequestFactory::fromGlobals());
$emitter = new SapiEmitter();


/** @noinspection PhpVoidFunctionResultUsedInspection */
return $emitter->emit($response);