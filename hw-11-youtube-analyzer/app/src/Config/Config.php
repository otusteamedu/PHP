<?php

namespace App\Config;

use Exception;
use App\Singleton\Singleton;
use Symfony\Component\Yaml\Yaml;

class Config extends Singleton
{
    /**
     * Путь к файлу конфига
     */
    private const CONFIG_FILE_PATH = '../config.yaml';

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
        $this->config = Yaml::parseFile(self::CONFIG_FILE_PATH);
    }

    /**
     * Получить элемент конфига
     *
     * @param string $key
     *
     * @return string
     * @throws Exception
     */
    public function getItem (string $key): string
    {
        if (!isset($this->config[$key])) {
            throw new Exception("Config record '{$this->config[$key]}' is not found");
        }

        return $this->config[$key];
    }
}