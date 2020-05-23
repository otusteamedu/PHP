<?php

namespace Core;

use Exception;
use Symfony\Component\Yaml\Yaml;

class ValidatorLoader
{
    /**
     * @return array
     */
    static public function load()
    {
        $validatorClasses = self::getConfig();
        $validators = [];
        foreach($validatorClasses as $validator) {
            $validators[] = ['order' => $validator['order'], 'validator' => new $validator['class']];
        }
        array_multisort($validators, array_column($validators, 'order'));
        return $validators;
    }

    /**
     * @return mixed
     * @throws Exception
     */
    private static function getConfig()
    {
        $config = Yaml::parseFile(__DIR__.'/../../config/config.yml');
        if (array_key_exists('validators', $config) && count($config['validators']) > 0) {
            return $config['validators'];
        } else {
            throw new Exception('Validators not registered');
        }
    }
}
