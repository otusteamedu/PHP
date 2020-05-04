<?php

namespace Validator;

use Exception;
use Http\Request;
use Symfony\Component\Yaml\Yaml;

final class ValidatorRegistrator
{
    
    /**
     * @param Request $request
     * @return array
     * @throws Exception
     */
    public static function registrateValidators(Request $request)
    {
        $validatorClasses = self::getConfig();
        $validators = [];
        foreach($validatorClasses as $validator) {
            $validators[] = ['order' => $validator['order'], 'validator' => new $validator['class']($request->getRequest(), $request->getHeaders())];
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
        $config = Yaml::parseFile(__DIR__.'/../../config/validators.yml');
        if (array_key_exists('validators', $config) && count($config['validators']) > 0) {
            return $config['validators'];
        } else {
            throw new Exception('Validators not registered');
        }
    }
}
