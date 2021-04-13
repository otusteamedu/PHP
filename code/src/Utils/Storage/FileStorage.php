<?php
declare(strict_types=1);

namespace App\Utils\Storage;


use App\Utils\Exception\DirectoryNotFoundException;
use App\Utils\Exception\FileNotFoundException;
use App\Utils\Exception\FileNotSaveException;

class FileStorage implements StorageInterface
{
    private string $path;

    /**
     * FileStorage constructor.
     * @param string $path
     * @throws \App\Utils\Exception\DirectoryNotFoundException
     */
    public function __construct(string $path)
    {
        if (!is_dir($path) && !mkdir($path)) {
            throw new DirectoryNotFoundException();
        }
        $this->path = $path;
    }


    /**
     * @throws FileNotSaveException
     */
    public function save(string $name, string $data): void
    {
        if (!file_put_contents($this->getFilename($name), $data)) {
            throw new FileNotSaveException();
        }
    }

    public function get(string $name): string
    {
        $fileName = $this->getFilename($name);

        if (!file_exists($fileName)) {
            throw new FileNotFoundException();
        }

        return $fileName;
    }

    private function getFilename(string $name): string
    {
        return $this->path . DIRECTORY_SEPARATOR . $name;
    }
}
