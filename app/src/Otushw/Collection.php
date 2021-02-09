<?php


namespace Otushw;

use Iterator;

/**
 * Class Collection
 *
 * @package Otushw
 */
class Collection implements Iterator
{

    /**
     * @var int
     */
    protected int $pointer = 0;

    /**
     * @var int
     */
    protected int $total = 0;

    /**
     * @var array
     */
    protected array $objects = [];

    /**
     * @return int
     */
    public function getTotal(): int
    {
        return $this->total;
    }

    /**
     * @param int $num
     */
    private function getRow(int $num)
    {
        if ($num >= $this->total || $num < 0) {
            return null;
        }

        if (isset($this->objects[$num])) {
            return $this->objects[$num];
        }

        return null;
    }

    public function current()
    {
        return $this->getRow($this->pointer);
    }

    public function next()
    {
        $this->pointer++;
        return $this->current();
    }

    /**
     * @return int
     */
    public function key(): int
    {
        return $this->pointer;
    }

    /**
     * @return bool
     */
    public function valid(): bool
    {
        return (!is_null($this->current()));
    }

    public function rewind()
    {
        $this->pointer = 0;
    }

    /**
     * @param $object
     */
    public function add($object): void
    {
        $this->objects[$this->total] = $object;
        $this->total++;
    }

    /**
     * @param $object
     */
    public function delete($object): void
    {
        $found = false;
        foreach ($this->objects as $key => $item) {
            if ($item === $object) {
                $found = true;
                break;
            }
        }
        if ($found) {
            unset($this->objects[$key]);
            $this->total--;
            $objects = $this->objects;
            unset($this->objects);
            $i = 0;
            foreach ($objects as $object) {
                $this->objects[$i++] = $object;
            }
        }
    }

}
