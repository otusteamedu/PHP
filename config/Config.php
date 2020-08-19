<?php

namespace Config;

use Symfony\Component\Yaml\Yaml;
use Symfony\Component\Yaml\Exception\ParseException;

class Config
{
    private static $config = null;

    /**
     * Функция возвращает объект конфигурации для заданного приложения
     * @param string $configPart название приложения для фильтрации
     * @return object
     */
    public static function config(string $configPart): object
    {
        try {
            $config = Yaml::parseFile(__DIR__ . '/config.yaml', Yaml::PARSE_OBJECT_FOR_MAP);
        } catch (ParseException $exception) {
            printf('Unable to parse the YAML string: %s', $exception->getMessage());
        }

        return $config->$configPart;
    }
}