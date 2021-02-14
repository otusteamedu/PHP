<?php

declare(strict_types=1);

namespace Nlazarev\Hw2_1\Model\DataLoader\FromArray;

use Nlazarev\Hw2_1\Model\DataLoader\Generic\IDataLoaderGeneric;
use Nlazarev\Hw2_1\Model\DataSource\Array\IDataSourceArray;

interface IDataLoaderFromArray extends IDataLoaderGeneric
{
    public function setDataSourceAsArray(IDataSourceArray $data_source);
}
