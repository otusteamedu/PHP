<?php

namespace Readers;

use Exception;

/**
 * Читает файл построчно
 *
 * Class RowsReader
 *
 * @package Readers
 */
class RowsReader
{
    /**
     * Путь к файлу
     *
     * @var string
     */
    private string $filePath;

    /**
     * RowsReader constructor.
     *
     * @param string $filePath
     */
    public function __construct (string $filePath)
    {
        $this->filePath = $filePath;
    }

    /**
     * @return array
     * @throws Exception
     */
    public function read (): array
    {
        $result = [];
        $handle = fopen($this->filePath, "r");
        if ($handle) {
            while (($buffer = fgets($handle, 4096)) !== false) {
                $result[] = $buffer;
            }
            if (!feof($handle)) {
                throw new Exception('При чтении из файла произошла ошибка');
            }
            fclose($handle);
        }

        return $result;
    }
}