<?php


namespace App;


use DI\ContainerBuilder;
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
        $appConfig = parse_ini_file(__DIR__ . '/../config/app.ini', );

        $this->init($appConfig);
    }

    public function run()
    {
        $this->app->run();
    }

    private function init(array $configs): void
    {
        $builder = new ContainerBuilder();
        $builder->addDefinitions($configs);
        $builder->addDefinitions(__DIR__ . '/../config/services.php');

        $container = $builder->build();


        $app = AppFactory::createFromContainer($container);

        $app->addRoutingMiddleware();
        $app->addBodyParsingMiddleware();
        $app->addErrorMiddleware($container->get('development'), false, false);

        $app->get('/', 'App\Controller\HomeController:index');
        $app->get('/channel', 'App\Controller\ChannelController:index');
        $app->map(['GET', 'POST'], '/test', 'App\Controller\ValidationController:index' );

        $this->app = $app;
    }

}

