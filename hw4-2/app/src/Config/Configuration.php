<?php

declare(strict_types=1);

namespace App\Config;

use DomainException;
use UnexpectedValueException;

class Configuration
{

    private array $params = [];

    public function __construct(string $pathToConfigIniFile)
    {
        $this->assertFileIsExist($pathToConfigIniFile);

        if (is_array($data = parse_ini_file($pathToConfigIniFile))) {
            $this->params = $data;
        } else {
            throw new DomainException('Ошибка при чтение файла конфигурации');
        }
    }

    private function assertFileIsExist(string $pathToFile): void
    {
        if (!file_exists($pathToFile)) {
            throw new DomainException("Файл конфигурации {$pathToFile} не найден");
        }
    }

    public function getParam($paramName): string
    {
        if (array_key_exists($paramName, $this->params) === false) {
            throw new UnexpectedValueException("Не указан параметр {$paramName}");
        }

        return $this->params[$paramName];
    }

}