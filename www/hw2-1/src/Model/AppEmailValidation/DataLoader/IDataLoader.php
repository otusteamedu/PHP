<?php

declare(strict_types=1);

namespace Nlazarev\Hw2_1\Model\AppEmailValidation\DataLoader;

use Nlazarev\Hw2_1\Model\Collections\ToCollection\IToCollection;
use Nlazarev\Hw2_1\Model\DataLoader\FromFile\IDataLoaderFromFile;

interface IDataLoader extends IDataLoaderFromFile, IToCollection
{
}
