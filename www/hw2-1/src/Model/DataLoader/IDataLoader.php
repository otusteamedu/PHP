<?php

declare(strict_types=1);

namespace Nlazarev\Hw2_1\Model\DataLoader;

use Nlazarev\Hw2_1\Model\DataLoader\FromFile\IDataLoaderFromFile;
use Nlazarev\Hw2_1\Model\DataLoader\FromFile\IDataLoaderFromFileStrings;
use Nlazarev\Hw2_1\Model\DataLoader\ToCollection\IDataLoaderToCollection;

interface IDataLoader extends IDataLoaderFromFile, IDataLoaderToCollection
{
}
