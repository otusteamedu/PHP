<?php

declare(strict_types=1);

namespace Nlazarev\Hw2_1\Model\Collections\Generic;

use Nlazarev\Hw2_1\Model\Collections\ICollection;

interface ICollectionGeneric extends ICollection
{
    public function push($value);
    public function get($key);
    public function set($key, $value);
    public function unset($key);
    public function keyLast();
    public function count(): int;
}
