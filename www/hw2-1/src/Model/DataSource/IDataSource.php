<?php

declare(strict_types=1);

namespace Nlazarev\Hw2_1\Model\DataSource;

use Nlazarev\Hw2_1\Model\DataSource\Array\IDataSourceArray;
use Nlazarev\Hw2_1\Model\DataSource\File\IDataSourceFile;

interface IDataSource extends IDataSourceFile, IDataSourceArray
{
}
