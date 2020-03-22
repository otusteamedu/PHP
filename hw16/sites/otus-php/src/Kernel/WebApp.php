<?php

declare(strict_types=1);

namespace App\Kernel;

use App\Configs\Config;
use DI\ContainerBuilder;
use Exception;

class WebApp extends Application
{
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
        Application::$services['app'] = $this;
        Application::$services['config'] = $config;
        Application::$services['db'] = Application::$services['config']->createDbClient();
        Application::$services['queueClient'] = Application::$services['config']->createQueueClient();
        Application::$services['request'] = $request;
        Application::$services['router'] = $router;
    }

    /**
     * @throws Exception
     */
    public static function run()
    {
        Config::setExceptionHandler();

        $container = ContainerBuilder::buildDevContainer();

        $app = $container->get(WebApp::class);

        $router = $app::getInstance('router');

        $controllerClass = $router->findController();
        $controller = $container->get($controllerClass);

        $controller->handler();
    }
}