<?php

namespace Config;

class ConfigGetter
{
    private static $config = null;

    public function __construct()
    {
        $this->config = require('config.php');
    }

    /**
     * Функция возвращает объект конфигурации для заданного приложения
     * @param $configPart название приложения для фильтрации
     * @return object
     */
    public static function config($configPart): object
    {
        $config = require('config.php');
        return $config->$configPart;
    }
}