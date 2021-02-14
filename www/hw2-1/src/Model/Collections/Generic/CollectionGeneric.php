<?php

declare(strict_types=1);

namespace Nlazarev\Hw2_1\Model\Collections\Generic;

abstract class CollectionGeneric implements ICollectionGeneric
{
    protected $values = array();

    //    abstract public function __construct(...$values);

    public function current()
    {
        return current($this->values);
    }

    public function key()
    {
        return key($this->values);
    }

    public function keyLast()
    {
        return array_key_last($this->values);
    }

    public function next()
    {
        next($this->values);
    }

    public function valid()
    {
        return current($this->values) !== false;
    }

    public function rewind()
    {
        reset($this->values);
    }

    public function push($value)
    {
        $this->values[] = $value;
    }

    public function set($key, $value)
    {
        $this->values[$key] = $value;
        return $this;
    }

    public function unset($key)
    {
        unset($this->values[$key]);
        return $this;
    }

    public function get($key)
    {
        return $this->values[$key];
    }

    public function count(): int
    {
        return count($this->values);
    }
}
