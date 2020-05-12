<?php

namespace Core;

use Symfony\Component\Yaml\Yaml;

class ValidatorLoader
{
    static public function load()
    {
        $config = Yaml::parse('config/config.yml');
        $config = array_multisort($config['validators'], array_column($config['validators'], 'order'));

        $result = [];
        foreach ($config as $validator) {
            $result = [new $validator()];
        }
        return $result;
    }
}