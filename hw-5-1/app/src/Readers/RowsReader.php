<?php

namespace Readers;

class RowsReader
{
    private string $filePath;

    public function __construct(string $filePath)
    {
        $this->filePath = $filePath;
    }

    public function read(): array
    {
        $result = [];
        $handle = fopen($this->filePath, "r");
        if ($handle) {
            while (($buffer = fgets($handle, 4096)) !== false) {
                $result[] = $buffer;
            }
            if (!feof($handle)) {
                throw new \Exception('При чтении из файла произошла ошибка');
            }
            fclose($handle);
        }

        return $result;
    }
}