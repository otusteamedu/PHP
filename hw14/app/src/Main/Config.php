<?php
/**
* Singleton config class
*
* @author Evgeny Prokhorov <prohorov-evgen@ya.ru>
*/
namespace Jekys\Main;

use Jekys\Abstraction\Singleton;

class Config extends Singleton
{
    /**
    * Saves all array data to the config
    *
    * @param array
    *
    * @return void
    */
    public function setConfig(array $configData): void
    {
        foreach ($configData as $property => $value) {
            $this->{$property} = $value;
        }
    }
}
