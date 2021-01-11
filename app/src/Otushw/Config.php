<?php

namespace Otushw;

use Exception;

class Config
{
    const FILE_NAME = 'config.ini';

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
        $result = parse_ini_file($this->filePath);
        if (empty($result)) {
            throw new Exception("Cann't read config.ini");
        }
        return $result;
    }

}