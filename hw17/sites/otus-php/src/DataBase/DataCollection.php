<?php

declare(strict_types=1);

namespace App\DataBase;

use ArrayIterator;

class DataCollection implements \IteratorAggregate
{
    /**
     * @var object[]
     */
    private $data;

    public function __construct(array $data)
    {
        $this->data = $data;
    }

    public function getIterator(): ArrayIterator
    {
        return new ArrayIterator($this->data);
    }
}
