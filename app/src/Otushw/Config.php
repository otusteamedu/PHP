<?php

namespace Otushw;

use Exception;

class Config
{
    const ROOT_PATH = __DIR__ . '/../../config.yaml';

    private function __construct()
    {
    }

    public static function create()
    {
        if (empty(file_exists(self::ROOT_PATH))) {
            throw new Exception(self::ROOT_PATH . ' does not exit.');
        }

        self::load(self::ROOT_PATH);
    }

    private function load(string $filePath): void
    {
        $data = self::process($filePath);
        foreach ($data as $key => $item) {
            $_ENV[$key] = $item;
        }
    }

    private function process(string $filePath): array
    {
        $data = [];

        foreach (self::readFile($filePath) as $varName => $varValue) {
            if (empty($varValue)) {
                throw new Exception('Config has empty variable "' . $varName . '"');
            }
            if (file_exists($varValue)) {
                $varValue = self::process($varValue);
            }
            $data[$varName] = $varValue;
        }

        return $data;
    }

    private function readFile(string $filePath): array
    {
        return \Symfony\Component\Yaml\Yaml::parseFile($filePath);
    }

}