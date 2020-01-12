<?php

namespace AI\backend_php_hw6_1\Settings;


use AI\backend_php_hw6_1\Exceptions\ConfigFileException;
use AI\backend_php_hw6_1\Exceptions\FileException;

class IniFileHandler
{
    private string $filename;
    private array $settings;

    public function __construct(string $filename)
    {
        $this->filename = $filename;
        $this->settings = $this->readIniFile();
    }

    /**
     * @return array
     */
    public function getSettings(): array
    {
        return $this->settings;
    }

    /**
     * @return array
     *
     * @throws ConfigFileException
     * @throws FileException
     */
    private function readIniFile(): array
    {
        if (!file_exists($this->filename)) {
            throw new FileException("Конфигурационный файл '{$this->filename}' не найден.");
        }

        $config = parse_ini_file($this->filename, false);
        if ($config === false) {
            $error = print_r(error_get_last(), true);
            throw new ConfigFileException(
                "Не удалось распознать конфигурационный файл '{$this->filename}':"
                . PHP_EOL . $error);
        }

        return $config;
    }
}
