<?php

namespace App\Config;

use Exception;
use App\Singleton\Singleton;
use Symfony\Component\Yaml\Yaml;

class Config extends Singleton
{
    /**
     * @var array
     */
    private array $config;

    /**
     * Установить конфиг
     *
     * @throws Exception
     */
    public function setConfig (string $path): void
    {
        $this->config = Yaml::parseFile($path);
    }

    /**
     * Получить элемент конфига
     *
     * @param string $key
     *
     * @return mixed
     * @throws Exception
     */
    public function getItem (string $key)
    {
        if (!isset($this->config[$key])) {
            throw new Exception("Config record '$key' is not found");
        }

        return $this->config[$key];
    }
}
