<?php

declare(strict_types=1);

namespace Nlazarev\Hw2_1\Model\DataSource\File;

use Nlazarev\Hw2_1\Model\DataSource\Generic\DataSourceGeneric;
use Nlazarev\Hw2_1\Model\File\IFile;

class DataSourceFile extends DataSourceGeneric implements IDataSourceFile
{
    public function fromFile(IFile $file)
    {
        if ($file->isReadable()) {
            $this->source = $file;
        } else {
            throw new \Exception("Not readable file");
        }
    }

    public function getSource(): IFile
    {
        return parent::getSource();
    }
}
