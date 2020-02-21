<?php

declare(strict_types=1);

namespace App\Kernel;

use App\Configs\Config;
use App\Exceptions\ExistClassException;
use App\Exceptions\KernelException;
use DI\Container;
use Exception;

class Application
{
    private static $services = [];

    // TODO db client
    private $db;


    /**
     * @param Config $config
     * @param Request $request
     * @param Router $router
     */
    public function __construct(
        Config $config,
        Request $request,
        Router $router
    ) {
        self::$services['config'] = $config;
        self::$services['db'] = self::$services['config']->createDbClient();
        self::$services['request'] = $request;
        self::$services['router'] = $router;
        self::$services['app'] = $this;
    }

    /**
     * @throws Exception
     */
    public static function run()
    {
        $container = new Container();
        $app = $container->get(Application::class);

        $router = $app::getInstance('router');

        $controllerClass = $router->findController();
        $controller = $container->get($controllerClass);

        $controller->handler();
    }

    /**
     * @param string $service
     * @return object
     * @throws KernelException
     */
    public static function getInstance($service = 'app'): object
    {
        if (!isset(self::$services[$service])) {
            throw new KernelException("Service {$service} not found");
        }

        return self::$services[$service];
    }

    public function isDev(): bool
    {
        return self::$services['config']->getEnvironment() == 'dev' ?: false ;
    }

    /**
     * @throws ExistClassException
     */
    public static function classExist($class)
    {
        if (!class_exists($class)) {
            throw new ExistClassException("Класс {$class} не существует");
        }
    }
}