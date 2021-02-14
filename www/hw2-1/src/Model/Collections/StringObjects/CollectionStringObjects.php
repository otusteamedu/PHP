<?php

declare(strict_types=1);

namespace Nlazarev\Hw2_1\Model\Collections\StringObjects;

use Nlazarev\Hw2_1\Model\Collections\Generic\CollectionGeneric;
use Nlazarev\Hw2_1\Model\General\String\IStringObject;

class CollectionStringObjects extends CollectionGeneric implements ICollectionStringObjects
{
    public function __construct(IStringObject ...$strings)
    {
        $this->values = $strings;
    }
}
