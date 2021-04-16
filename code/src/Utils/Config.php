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
        $builder->addDefinitions(self::CONFIG_DIR . '/services.php');
        $container = $builder->build();

        $container->set(DatabaseConfiguration::class, function() {
            return self::getDatabaseConfiguration();
        });

        return $container;
    }

    private static function getDatabaseConfiguration(): DatabaseConfiguration
    {
        $config = require self::CONFIG_DIR . '/database.php';

        return new DatabaseConfiguration(...array_values($config['postgres']));
    }
}
