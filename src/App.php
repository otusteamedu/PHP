<?php

namespace Bjlag;

use Bjlag\Http\Middleware\BodyParamsMiddleware;
use Bjlag\Template\Template;
use Laminas\Diactoros\Response;
use Laminas\Diactoros\ServerRequestFactory;
use Laminas\HttpHandlerRunner\Emitter\SapiEmitter;
use League\Route\Http\Exception;
use League\Route\Http\Exception\NotFoundException;
use League\Route\Strategy\ApplicationStrategy;
use Symfony\Component\Dotenv\Dotenv;

class App
{
    /** @var string */
    private static $baseDir;

    /** @var \Bjlag\Container */
    private static $container;

    /** @var Template */
    private static $template = null;

    /** @var \League\Route\Router */
    private $router;

    public function __construct()
    {
        self::$baseDir = dirname(__DIR__);
        self::$container = new Container(include self::getBaseDir() . '/config/container.php');

        $router = new \League\Route\Router();
        $router->middleware(new BodyParamsMiddleware());

        $strategy = (new ApplicationStrategy())->setContainer(self::$container);
        $router->setStrategy($strategy);

        (include self::getBaseDir() . '/config/routes.php')($router);

        $this->router = $router;

        if (file_exists(self::getBaseDir() . '/.env')) {
            (new Dotenv(true))->load(self::getBaseDir() . '/.env');
        } else {
            throw new \RuntimeException('Не определен файл окружения .env.');
        }
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
        } catch (Exception $e) {
            $response = (new Response())->withStatus($e->getStatusCode());
            $response->getBody()->write($e->getMessage());
        } catch (\Throwable $e) {
            $response = (new Response())->withStatus(500);
            $response->getBody()->write("Ошибка сервера: {$e->getMessage()}");
        }

        (new SapiEmitter())->emit($response);
    }

    /**
     * @return \Bjlag\Template\Template
     */
    public static function getTemplate(): Template
    {
        if (self::$template === null) {
            $template = self::$container->get('template');
            if (!($template instanceof Template)) {
                throw new \RuntimeException("Шаблонизатор реализован неверно.");
            }

            self::$template = $template;
        }

        return self::$template;
    }

    /**
     * @return \Bjlag\Container
     */
    public static function getContainer(): \Bjlag\Container
    {
        return self::$container;
    }

    /**
     * @return string
     */
    public static function getBaseDir(): string
    {
        return self::$baseDir;
    }
}
