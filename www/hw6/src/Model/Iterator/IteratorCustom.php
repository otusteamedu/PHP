<?php

declare(strict_types=1);

namespace Nlazarev\Hw6\Model\Iterator;

abstract class IteratorCustom implements IIteratorCustom
{
    private int $position = 0;

    abstract public function current();
    abstract public function valid(): bool;

    public function key(): int
    {
        return $this->position;
    }

    public function next(): void
    {
        ++$this->position;
    }

    public function rewind(): void
    {
        $this->position = 0;
    }
}
