<?php

namespace Otushw;

use Otushw\Exception\AppException;

/**
 * Class Config
 *
 * @package Otushw
 */
class Config
{
    /**
     * @var string
     */
    private string $filePath;

    /**
     * Config constructor.
     *
     * @param string $filePath
     *
     * @throws AppException
     */
    public function __construct(string $filePath = '')
    {
        if (empty($filePath)) {
            $filePath = self::FILE_NAME;
        }

        if (empty(file_exists($filePath))) {
            throw new AppException($filePath . ' does not exit.');
        }

        $this->filePath = $filePath;
    }

    /**
     * @throws AppException
     */
    public function load(): void
    {
        foreach ($this->readFile() as $varName => $varValue) {
            if (empty($varValue)) {
                throw new AppException('Config has empty variable "' . $varName . '"');
            }
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