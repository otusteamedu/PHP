<?php

declare(strict_types=1);

abstract class AbstractCollection implements Countable, Iterator, ArrayAccess
{
    protected array $collection = [];

    private int $index = 0;

    public function add($item)
    {
        $this->collection[] = $item;
    }

    /**
     * @return mixed
     */
    public function current()
    {
        return $this->collection[$this->index];
    }

    public function next(): void
    {
        ++$this->index;
    }

    public function key(): int
    {
        return $this->index;
    }

    public function valid(): bool
    {
        return isset($this->collection[$this->index]);
    }

    public function rewind(): void
    {
        $this->index = 0;
    }

    public function count(): int
    {
        return count($this->collection);
    }

    /**
     * @param int $offset
     * @return bool
     */
    public function offsetExists($offset): bool
    {
        return isset($this->collection[$offset]);
    }

    /**
     * @param int $offset
     * @return mixed|null
     */
    public function offsetGet($offset)
    {
        return $this->collection[$offset] ?? null;
    }

    /**
     * @param int $offset
     * @param mixed $value
     */
    public function offsetSet($offset, $value)
    {
        if (null === $offset) {
            $this->collection[] = $value;
        } else {
            $this->collection[$offset] = $value;
        }
    }

    /**
     * @param int $offset
     */
    public function offsetUnset($offset)
    {
        unset($this->collection[$offset]);
    }

    /**
     * @return bool
     */
    public function isEmpty(): bool
    {
        return empty($this->collection);
    }
}
