<?php

namespace Otushw;

use Exception;

class Config
{
    const FILE_NAME = 'config.yaml';

    private string $filePath;

    public function __construct(string $filePath = '')
    {
        if (empty($filePath)) {
            $filePath = self::FILE_NAME;
        }

        if (empty(file_exists($filePath))) {
            throw new Exception($filePath . ' does not exit.');
        }

        $this->filePath = $filePath;
    }

    public function load(): void
    {
        foreach ($this->readFile() as $varName => $varValue) {
            if (empty($varValue)) {
                throw new Exception('Config has empty variable "' . $varName . '"');
            }
            $_ENV[$varName] = $varValue;
        }
    }

    private function readFile(): array
    {
        return \Symfony\Component\Yaml\Yaml::parseFile($this->filePath);
    }

}