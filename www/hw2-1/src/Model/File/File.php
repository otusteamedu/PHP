<?php

declare(strict_types=1);

namespace Nlazarev\Hw2_1\Model\File;

abstract class File implements IFile
{
    private string $path;

    public function setPath(string $path)
    {
        $this->path = $path;
    }

    public function getPath(): ?string
    {
        return $this->path;
    }

    public function isExists(): bool
    {
        if (!is_file($this->path)) {
            return false;
        }

        return true;
    }

    public function isReadable(): bool
    {
        if (!is_readable($this->path)) {
            return false;
        }

        return true;
    }
}
