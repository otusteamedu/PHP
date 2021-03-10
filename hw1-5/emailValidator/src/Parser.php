<?php

namespace Src;

/**
 * Class Parser
 *
 * @package Src
 */
class Parser
{
    /**
     * @var string $filePath
     */
    private string $filePath;

    /**
     * Parser constructor.
     *
     * @param string $filePath
     */
    public function __construct(string $filePath)
    {
        $this->filePath = $filePath;
    }

    /**
     * @return array|bool
     * @throws \Exception
     */
    public function parse()
    {
        $result = file($this->filePath, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
        if ($result === false) {
            throw new \Exception('Error read file');
        }

        return $result;
    }
}