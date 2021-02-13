<?php

declare(strict_types=1);

namespace Nlazarev\Hw2_1\Model\DataSource\Array;

use Nlazarev\Hw2_1\Model\DataSource\Generic\IDataSourceGeneric;

interface IDataSourceArray extends IDataSourceGeneric
{
    public function fromArray(array $source);
}
