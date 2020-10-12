<?php

namespace Otus\Entities;

use ArrayAccess;
use Countable;
use Iterator;

class MailCollection implements ArrayAccess, Iterator, Countable
{
    private array $items = [];

    private int $position = 0;

    public function __construct(array $items)
    {
        foreach ($items as $item) {
            $this->items[] = new Mail($item);
        }
    }

    public function offsetExists($offset)
    {
        return array_key_exists($offset, $this->items);
    }

    public function offsetGet($offset)
    {
        return $this->items[$offset] ?? null;
    }

    public function offsetSet($offset, $value)
    {
        if (is_null($offset)) {
            $this->items[] = $value;
        } else {
            $this->items[$offset] = $value;
        }
    }

    public function offsetUnset($offset)
    {
        unset($this->items[$offset]);
    }

    public function current()
    {
        return $this->items[$this->position];
    }

    public function next()
    {
        $this->position++;
    }

    public function key()
    {
        return $this->position;
    }

    public function valid()
    {
        return array_key_exists($this->position, $this->items);
    }

    public function rewind()
    {
        $this->position = 0;
    }

    public function count()
    {
        return count($this->items);
    }

    public function getItems(): array
    {
        return $this->items;
    }
}
