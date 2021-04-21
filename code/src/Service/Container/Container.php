<?php


namespace App\Service\Container;


use App\Service\Container\Exception\NotFoundException;
use Psr\Container\ContainerInterface;


class Container implements ContainerInterface
{
    private array $data = [];
    private array $definitions = [];

    public function addDefinitions(array $definitions)
    {
        $this->definitions = array_merge($this->definitions, $definitions);
    }

    public function set(string $id, $data): void
    {
        $this->data[$id] = $data;
    }

    /**
     * @inheritDoc
     */
    public function get(string $id)
    {
        if (array_key_exists($id, $this->data)) {
            return $this->data[$id];
        } elseif (array_key_exists($id, $this->definitions)) {
            return $this->addDefinition($id);
        }
        throw new NotFoundException();
    }

    /**
     * @inheritDoc
     */
    public function has(string $id): bool
    {
        return array_key_exists($id, $this->data)
         || array_key_exists($id, $this->definitions);
    }

    private function addDefinition($id)
    {
        $data = $this->definitions[$id];

        switch (gettype($data)) {
            case 'boolean':
            case 'integer':
            case 'string':
                $this->set($id, $data);
                return $data;

            case 'object':
                $obj = is_callable($data)
                    ? $this->compile($data)
                    : $data;

                $this->set($id, $obj);
                return $obj;
        }
    }

    private function compile(callable $definition): object
    {
        return call_user_func($definition, $this);
    }
}
