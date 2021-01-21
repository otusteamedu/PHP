<?php

namespace Config;

use Exception;

class Config
{
    /**
     * Путь к файлу конфига
     */
    private const CONFIG_FILE_PATH = '../config.ini';

    /**
     * @var array
     */
    private array $config;

    /**
     * Config constructor.
     *
     * @throws Exception
     */
    public function __construct ()
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
        $config = parse_ini_file(self::CONFIG_FILE_PATH);

        if ($config === false) {
            throw new Exception('Config reading error');
        }

        $this->config = $config;
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
