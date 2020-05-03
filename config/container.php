<?php

use Bjlag\App;
use Bjlag\Db\Store;
use Bjlag\Template\Adapters\Twig;
use Bjlag\Template\Template;
use Psr\Container\ContainerInterface;

return [
    'cache_dir' => function () {
        return App::getBaseDir() . '/cache';
    },
    'template_dir' => function () {
        return App::getBaseDir() . '/src/Views';
    },
    Template::class => function (ContainerInterface $container) {
        static $template;

        if ($template === null) {
            $template = new Twig($container->get('template_dir'), $container->get('cache_dir'));
        }

        return $template;
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
