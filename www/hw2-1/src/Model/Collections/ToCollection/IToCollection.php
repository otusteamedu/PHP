<?php

declare(strict_types=1);

namespace Nlazarev\Hw2_1\Model\Collections\ToCollection;

use Nlazarev\Hw2_1\Model\Collections\Generic\ICollectionGeneric;

interface IToCollection
{
    public function toCollection(ICollectionGeneric $collection);
}
