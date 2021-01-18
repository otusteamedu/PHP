<?php

namespace Otushw;

use Exception;

class Config
{
    private string $filePath;

    public function __construct(string $filePath = '')
    {
        if (empty($filePath)) {
            $filePath = self::FILE_NAME;
        }

        if (empty(file_exists($filePath))) {
            throw new UserException($filePath . ' does not exit.');
        }

        $this->filePath = $filePath;
    }

    public function load()
    {
        foreach ($this->readFile() as $varName => $varValue) {
            $_ENV[$varName] = $varValue;
        }
    }

    /**
     * @return array
     * @throws Exception
     */
    private function readFile(): array
    {
        return \Symfony\Component\Yaml\Yaml::parseFile($this->filePath);
    }

}