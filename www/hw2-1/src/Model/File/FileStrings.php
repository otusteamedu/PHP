<?php

declare(strict_types=1);

namespace Nlazarev\Hw2_1\Model\File;

class FileStrings extends File implements IFileStrings
{
    public function __construct(string $path)
    {
        $this->setPath($path);
    }
}
