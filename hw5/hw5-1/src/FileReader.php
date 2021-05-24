<?php


namespace Src;


class FileReader
{
    private $filePath;

    public function __construct($filePath)
    {
        $this->filePath = $filePath;
    }

    public function read(): array
    {
        $file = fopen($this->filePath, 'r');
        $result = [];

        if ($file) {
            while($row = fgets($file)) {
                $result[] = $row;
            }

            if (!feof($file)) throw new \Exception('File read error');

            fclose($file);
        }

        return $result;
    }
}