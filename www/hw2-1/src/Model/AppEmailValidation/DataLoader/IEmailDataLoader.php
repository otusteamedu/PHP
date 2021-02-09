<?php

declare(strict_types=1);

namespace Nlazarev\Hw2_1\Model\AppEmailValidation\DataLoader;

use Nlazarev\Hw2_1\Model\DataLoader\FromFile\IDataLoaderFromFileStrings;
use Nlazarev\Hw2_1\Model\DataLoader\ToCollection\IDataLoaderToCollection;

interface IEmailDataLoader extends IDataLoaderFromFileStrings, IDataLoaderToCollection
{
}
