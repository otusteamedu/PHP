<?php

namespace Otus\Config;

use Symfony\Component\Yaml\Yaml;

class ConfigFactory
{
    public static function make(): ConfigContract
    {
        $items = Yaml::parseFile($_SERVER['DOCUMENT_ROOT'].'/../config/config.yaml');

        $config = new Config($items);

        return $config->set('redis_host', $_ENV['REDIS_HOST'])
                      ->set('redis_port', $_ENV['REDIS_PORT']);
    }
}