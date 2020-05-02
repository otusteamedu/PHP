<?php

namespace Bjlag;

use Bjlag\Db\Store;
use Bjlag\Http\Middleware\BodyParamsMiddleware;
use Bjlag\Template\Template;
use Laminas\Diactoros\Response;
use Laminas\Diactoros\ServerRequestFactory;
use Laminas\HttpHandlerRunner\Emitter\SapiEmitter;
use League\Route\Http\Exception;
use League\Route\Http\Exception\BadRequestException;
use League\Route\Http\Exception\NotFoundException;
use League\Route\Http\Exception\UnprocessableEntityException;
use League\Route\Strategy\ApplicationStrategy;
use Symfony\Component\Dotenv\Dotenv;

class App
{
    /** @var string */
    private static $baseDir;

    /** @var string */
    private static $templateDir;

    /** @var string */
    private static $cacheDir;

    /** @var Template */
    private static $template = null;

    /** @var \Bjlag\Db\Store */
    private static $db = null;

    /** @var \League\Route\Router */
    private $router;

    public function __construct()
    {
        self::$baseDir = dirname(__DIR__);
        self::$templateDir = self::$baseDir . '/src/Views';
        self::$cacheDir = self::$baseDir . '/cache';

        $router = new \League\Route\Router();
        $router->middleware(new BodyParamsMiddleware());

        $strategy = (new ApplicationStrategy())->setContainer(new Container());
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
     * @return \Bjlag\Db\Store
     */
    public static function getDb(): Store
    {
        if (self::$db === null) {
            $uri = getenv('DB_URI');
            $dbName = getenv('DB_NAME');
            $adapter = getenv('DB_ADAPTER');
            $adapterClass = '\\Bjlag\\Db\\Adapters\\' . $adapter;

            if (!class_exists($adapterClass)) {
                throw new \RuntimeException("Адаптер БД не найден: {$adapterClass}.");
            }

            /** @var \Bjlag\Db\Store $db */
            $db = (new $adapterClass());
            if (!($db instanceof Store)) {
                throw new \RuntimeException("Адаптер БД не найден: {$adapterClass}.");
            }

            self::$db = $db->getConnection($uri, $dbName);
        }

        return self::$db;
    }

    /**
     * @return \Bjlag\Template\Template
     */
    public static function getTemplate(): Template
    {
        if (self::$template === null) {
            $adapter = 'Twig';
            $adapterClass = '\\Bjlag\\Template\\Adapters\\' . $adapter;

            if (!class_exists($adapterClass)) {
                throw new \RuntimeException("Шаблонизатор не найзен: {$adapterClass}.");
            }

            $template = new $adapterClass(self::getCacheDir() . '/twig');
            if (!($template instanceof Template)) {
                throw new \RuntimeException("Шаблонизатор не найзен: {$adapterClass}.");
            }

            self::$template = $template;
        }

        return self::$template;
    }

    /**
     * @return string
     */
    public static function getTemplateDir(): string
    {
        return self::$templateDir;
    }

    /**
     * @return string
     */
    public static function getCacheDir(): string
    {
        return self::$cacheDir;
    }

    /**
     * @return string
     */
    public static function getBaseDir(): string
    {
        return self::$baseDir;
    }
}
