<?php


namespace App;


use App\Repository\Cache\MemcachedCacheClick;
use App\Repository\Cache\RedisCacheClick;
use DI\ContainerBuilder;
use Slim\Factory\AppFactory;
use Slim\App as SlimApp;


final class App
{
    const CONFIG_DIR = __DIR__ . '/../config';
    private SlimApp $app;

    /**
     * App constructor.
     */
    public function __construct()
    {
        $appConfig = parse_ini_file(self::CONFIG_DIR . '/app.ini', );

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
        $builder->addDefinitions(self::CONFIG_DIR . '/services.php');

        $container = $builder->build();

        // set cache client (memcached | redis)
        $cacheClient = $container->get('cache_click_client');
        $container->set('cache_click_client', $container->get($cacheClient));

        $app = AppFactory::createFromContainer($container);

        $app->addRoutingMiddleware();
        $app->addBodyParsingMiddleware();
        $app->addErrorMiddleware($container->get('development'), false, false);

        (require self::CONFIG_DIR . '/routes.php')($app);

        $this->app = $app;
    }

}

