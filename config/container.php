<?php

use Bjlag\App;
use Bjlag\Db\Store;
use Bjlag\Template\Adapters\Twig;
use Psr\Container\ContainerInterface;

return [
    'cache_dir' => function () {
        return App::getBaseDir() . '/cache';
    },
    'template_dir' => function () {
        return App::getBaseDir() . '/src/Views';
    },
    'template' => function (ContainerInterface $container) {
        return new Twig($container->get('cache_dir'));
    },
    Store::class => function () {
        static $db;

        if ($db === null) {
            $db = (new \Bjlag\Db\Adapters\MongoDb())
                ->getConnection(getenv('DB_URI'), getenv('DB_NAME'));
        }

        return $db;
    },
];
