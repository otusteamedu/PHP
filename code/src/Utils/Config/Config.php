<?php


namespace App\Utils\Config;

use App\Service\Container\Container;

use Psr\Container\ContainerInterface;


class Config
{
    const CONFIG_DIR = __DIR__ . '/../../../config';

    public static function buildContainer(): ContainerInterface
    {
        $container = new Container();
        $container->addDefinitions(require self::CONFIG_DIR . '/services.php');

        return $container;
    }
}
