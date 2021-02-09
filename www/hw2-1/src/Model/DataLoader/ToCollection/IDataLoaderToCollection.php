<?php

declare(strict_types=1);

namespace Nlazarev\Hw2_1\Model\DataLoader\ToCollection;

use Nlazarev\Hw2_1\Model\Collections\Generic\ICollectionGeneric;

interface IDataLoaderToCollection
{
    public function toCollection(ICollectionGeneric $collection);
}
