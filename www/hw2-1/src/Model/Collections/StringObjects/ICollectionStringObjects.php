<?php

declare(strict_types=1);

namespace Nlazarev\Hw2_1\Model\Collections\StringObjects;

use Nlazarev\Hw2_1\Model\Collections\Generic\ICollectionGeneric;
use Nlazarev\Hw2_1\Model\General\String\IStringObject;

interface ICollectionStringObjects extends ICollectionGeneric
{
    public function __construct(IStringObject ...$strings);
}
