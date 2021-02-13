<?php

declare(strict_types=1);

namespace Nlazarev\Hw2_1\Model\DataLoader\FromFile;

use Nlazarev\Hw2_1\Model\DataLoader\Generic\IDataLoaderGeneric;
use Nlazarev\Hw2_1\Model\DataSource\File\IDataSourceFile;

interface IDataLoaderFromFile extends IDataLoaderGeneric
{
    public function getDataSource(): IDataSourceFile;
    public function setDataSourceAsFile(IDataSourceFile $data_source);
}
