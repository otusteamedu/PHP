<?php
// app/Provider/RenderProvider.php

namespace App\Provider;

use App\Support\Config;
use App\Support\ServiceProviderInterface;
use Psr\Container\ContainerInterface;
use Twig\Environment;
use Twig\Loader\FilesystemLoader;
use UltraLite\Container\Container;

class RenderProvider implements ServiceProviderInterface
{
    public function register(Container $container)
    {
        $container->set(Environment::class, function (ContainerInterface $container) {
            $config = $container->get(Config::class);
            $loader = new FilesystemLoader($config->get('templates.dir'));
            $cache = $config->get('templates.cache');
            $options = [
                'cache' => empty($cache) ? false : $cache,
            ];
            $twig = new Environment($loader, $options);
            return $twig;
        });
    }
}