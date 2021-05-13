<?php


namespace App\Model\Youtube;


abstract class AbstractEntity
{
    private array $data;

    public function __construct(array $data = [])
    {
        $this->data = $data;
    }

    public function __call($name, $arguments)
    {
        $prefix = substr($name, 0, 3);
        $attribute = lcfirst(substr($name, 3));
        if ($prefix === 'get') {
            return $this->__get($attribute);
        }
        if ($prefix === 'set') {
            $value = $arguments[0] ?? null;
            $this->__set($attribute, $value);
        }
    }

    public function __get($name)
    {
        return $this->data[$name] ?? null;
    }

    public function __set($name, $value)
    {
        $this->data[$name] = $value;
    }

    public function getData(): array
    {
        return $this->data;
    }
}