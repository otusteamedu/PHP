<?php

declare(strict_types=1);

namespace Nlazarev\Hw2_1\Model\DataSource\File;

use Nlazarev\Hw2_1\Model\DataSource\Generic\IDataSourceGeneric;
use Nlazarev\Hw2_1\Model\File\IFile;
use Nlazarev\Hw2_1\Model\File\IFromFile;

interface IDataSourceFile extends IDataSourceGeneric, IFromFile
{
    public function getSource(): IFile;
}
