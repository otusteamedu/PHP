<?php
declare(strict_types=1);


namespace App\Repository;


use App\Utils\Exception\DirectoryNotFoundException;

class DocFilesRepository implements RepositoryInterface
{
    private string $path;

    /**
     * DocFilesRepository constructor.
     * @param string $path
     * @throws \App\Utils\Exception\DirectoryNotFoundException
     */
    public function __construct(string $path)
    {
        if (!is_dir($path)) {
            throw new DirectoryNotFoundException('Directory not found.');
        }
        $this->path = $path;
    }


    public function findAll(): array
    {
        $files = scandir($this->path);
        $docs = [];
        foreach ($files as $file) {
            if (preg_match('/.*\.docx$/', $file)) {
                array_push(
                    $docs,
                    $this->path . DIRECTORY_SEPARATOR . $file
                );
            }
        }
        return $docs;
    }
}
