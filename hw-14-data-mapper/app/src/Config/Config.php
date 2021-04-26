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
     * Config constructor.
     *
     * @throws Exception
     */
    protected function __construct ()
    {
        $this->setConfig();
    }

    /**
     * Установить конфиг
     *
     * @throws Exception
     */
    private function setConfig (): void
    {
        $this->config = Yaml::parseFile('../config.yml');
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
