<?php

declare(strict_types=1);

namespace Nlazarev\Hw2_1\Model\File;

use Nlazarev\Hw2_1\Model\File\IFile;

interface IFromFile
{
    public function fromFile(IFile $file);
}
