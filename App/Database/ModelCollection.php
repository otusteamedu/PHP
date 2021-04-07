<?php


namespace App\Database;


use Ds\Collection;

class ModelCollection implements Collection
{

    private array $items = [];

    public function __construct(array $items = [])
    {
        foreach ($items as $item) {
            $this->add($item);
        }
    }

    public function add(Model $model)
    {
        $this->items[] = $model;
    }

    public function get($key): ?Model
    {
        foreach ($this->items as $item) {
            $pk = $item->getKey();
            if ($item->$pk === $key) {
                return $item;
            }
        }
        return null;
    }

    function clear()
    {
        $this->items = [];
        return $this;
    }

    function count(): int
    {
        return count($this->items);
    }

    function copy()
    {
        return clone $this;
    }

    function isEmpty(): bool
    {
        return empty($this->items);
    }

    function toArray(): array
    {
        return array_map(static function ($model) {
            return $model->toArray();
        }, $this->items);
    }

    public function getIterator()
    {
        return new \ArrayIterator($this->items);
    }

    public function jsonSerialize()
    {
        return json_encode($this->toArray());
    }
}