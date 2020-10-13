<?php

namespace helper;
/**
 * Class ConfigHelper
 *
 * @package helper
 * @author  Petr Ivanov (petr.yrs@gmail.com)
 */
class ConfigHelper
{
    public $configFile = __DIR__ . '/../../config/main.ini';


    /**
     * Прочитать конфиг
     *
     * @return array|false
     */
    public function readConfig()
    {
        return parse_ini_file($this->configFile);
    }
}