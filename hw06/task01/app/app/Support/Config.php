<?php
// app/Support/Config.php

namespace App\Support;

class Config
{

    /**
     * @var string[]
     */
    private $config = [];

    public function __construct(string $dir, string $env, string $root)
    {
        if (!is_dir($dir)) return;

        /*
         * Парсим основной конфиг
         */
        $config = (array)parse_ini_file($dir . DIRECTORY_SEPARATOR . 'app.ini', false);

        /*
         * Переопределяем параметры из конфига окружения
         */
        $environmentConfigFile = $dir . DIRECTORY_SEPARATOR . 'app.' . $env . '.ini';
        if (is_readable($environmentConfigFile)) {
            $config = array_replace_recursive($config, (array)parse_ini_file($environmentConfigFile, false));
        }

        /*
         * Указываем, какие параметры конфига являются путями
         */
        $dirs = ['templates.dir', 'templates.cache'];

        foreach ($config as $name=>$value) {
            $this->config[$name] = $value;
        }

        /*
         * Устанавливаем абсолютные пути в конфигурации
         */
        foreach ($dirs as $parameter) {
            $value = $config[$parameter];
            if (mb_strpos($value, '/') === 0) {
                continue;
            }
            if (empty($value)) {
                $this->config[$parameter] = null;
                continue;
            }
            $this->config[$parameter] = $root . DIRECTORY_SEPARATOR . $value;
        }
    }

    public function get(string $name)
    {
        return array_key_exists($name, $this->config) ? $this->config[$name] : null;
    }
}