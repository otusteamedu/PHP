<?php

namespace Bjlag;

use Bjlag\Http\Middleware\BodyParamsMiddleware;
use Laminas\Diactoros\Response;
use Laminas\Diactoros\ServerRequestFactory;
use Laminas\HttpHandlerRunner\Emitter\SapiEmitter;
use League\Route\Http\Exception\NotFoundException;

class App
{
    /** @var string */
    private static $baseDir;

    /** @var \League\Route\Router */
    private $router;

    public function __construct()
    {
        self::$baseDir = dirname(__DIR__);

        $router = new \League\Route\Router();
        $router->middleware(new BodyParamsMiddleware());

        (include self::getBaseDir() . '/config/routes.php')($router);

        $this->router = $router;
    }

    /**
     * App run.
     */
    public function run(): void
    {
        try {
            $request = ServerRequestFactory::fromGlobals();
            $response = $this->router->dispatch($request);
        } catch (NotFoundException $e) {
            $response = (new Response())->withStatus(404);
            $response->getBody()->write('Страница не найдена');
        } catch (\Throwable $e) {
            $response = (new Response())->withStatus(500);
            $response->getBody()->write("Ошибка сервера: {$e->getMessage()}");
        }

        (new SapiEmitter())->emit($response);
    }

    /**
     * @return string
     */
    public static function getBaseDir(): string
    {
        return self::$baseDir;
    }
}
