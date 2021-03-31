<?php


namespace App\Utils;

use DI\ContainerBuilder;
use Psr\Container\ContainerInterface;


class Config
{
    const CONFIG_DIR = __DIR__ . '/../../config';

    public static function buildContainer(): ContainerInterface
    {
        $builder = new ContainerBuilder();

        $appConfig = parse_ini_file(self::CONFIG_DIR . '/app.ini', );

        $builder->addDefinitions($appConfig);
        $builder->addDefinitions(self::CONFIG_DIR . '/services.php');

        $container = $builder->build();

        // set cache client (memcached | redis)
        $container->set(
            'cache_click_client',
            $container->get($appConfig['cache_click_client'])
        );

        return $container;
    }

    public static function buildContainerForConsole(): ContainerInterface
    {
        $builder = new ContainerBuilder();
        $builder->addDefinitions(self::CONFIG_DIR . '/services.php');
        return $builder->build();
    }

//    public static function getDatabaseConnection(): array
//    {
//        $dsn = sprintf(
//            '%s:host=%s;port=%d;dbname=%s',
//            'pgsql',
//            getenv('DB_HOST'),
//            getenv('DB_PORT'),
//            getenv('POSTGRES_DB')
//        );
//
//        return [$dsn, getenv('POSTGRES_USER'), getenv('POSTGRES_PASSWORD')];
//    }

}
