<?php


namespace App;


use App\Utils\Config;
use Psr\Container\ContainerInterface;
use Slim\Factory\AppFactory;
use Slim\App as SlimApp;


final class App
{
    private SlimApp $app;

    /**
     * App constructor.
     */
    public function __construct()
    {
        $container = Config::buildContainer();

        $this->init($container);

        Config::setRoutes($this->app);
    }

    public function run()
    {
        $this->app->run();
    }

    private function init(ContainerInterface $container): void
    {
        $app = AppFactory::createFromContainer($container);

        $app->addRoutingMiddleware();
        $app->addBodyParsingMiddleware();
        $app->addErrorMiddleware($container->get('development'), false, false);

        $this->app = $app;
    }

}

