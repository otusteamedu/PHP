<?php


namespace App;


use DI\Container;
use Slim\Factory\AppFactory;


final class App
{
    private \Slim\App $app;

    /**
     * App constructor.
     */
    public function __construct()
    {
        $container = new Container();
        AppFactory::setContainer($container);
        $app = AppFactory::create();

        $app->addRoutingMiddleware();
        $app->addBodyParsingMiddleware();
        $app->addErrorMiddleware(true, false, false);


        $app->get('/', 'App\Controller\HomeController:index');
        $app->post('/', 'App\Controller\HomeController:index');

        $this->app = $app;
    }

    public function run()
    {
        $this->app->run();
    }

}

