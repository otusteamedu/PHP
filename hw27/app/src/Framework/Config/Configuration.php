<?php

declare(strict_types=1);

namespace App\Framework\Config;

use DomainException;
use UnexpectedValueException;

class Configuration
{
    private array $params;

    public function __construct(string $pathToConfigIniFile)
    {
        $this->assertFileIsExist($pathToConfigIniFile);

        $data = parse_ini_file($pathToConfigIniFile, true);

        $this->assertConfigDataIsValid($data);
        $this->assertConfigDataIsNotEmpty($data);

        $this->params = $data;
    }

    private function assertFileIsExist(string $pathToFile): void
    {
        if (!file_exists($pathToFile)) {
            throw new DomainException("Файл конфигурации $pathToFile не найден");
        }
    }

    private function assertConfigDataIsValid($data): void
    {
        if ($data === false) {
            throw new DomainException('Некорректно заполнен файл конфигурации');
        }
    }

    private function assertConfigDataIsNotEmpty(array $data): void
    {
        if (!$data) {
            throw new DomainException('Файл конфигурации не заполнен');
        }
    }

    /**
     * @param string $paramName
     *
     * @return string|array
     */
    public function getParam(string $paramName)
    {
        if (array_key_exists($paramName, $this->params) === false) {
            throw new UnexpectedValueException("Параметр $paramName не указан");
        }

        return $this->params[$paramName];
    }
}