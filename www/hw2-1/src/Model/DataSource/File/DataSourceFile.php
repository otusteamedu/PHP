<?php

declare(strict_types=1);

namespace Nlazarev\Hw2_1\Model\DataSource\File;

class DataSourceFile implements IDataSourceFile
{
    private ?string $path = null;

    public function __construct(string $path)
    {
        $this->path = $path;
    }

    public function getPath(): string
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
