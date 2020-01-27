<?php

declare(strict_types=1);

use Socket\Ruvik\DTO\RouteConfig;

class RouteConfigCollection extends AbstractCollection
{
    /**
     * @param RouteConfig $item
     */
    public function add($item)
    {
        $this->checkValid($item);

        parent::add($item);
    }

    /**
     * @param int $offset
     * @return RouteConfig|null
     */
    public function offsetGet($offset): ?RouteConfig
    {
        return parent::offsetGet($offset);
    }

    /**
     * @param int $offset
     * @param RouteConfig $value
     */
    public function offsetSet($offset, $value)
    {
        $this->checkValid($value);

        parent::offsetSet($offset, $value);
    }

    /**
     * @return RouteConfig
     */
    public function current(): RouteConfig
    {
        return parent::current();
    }

    private function checkValid($value): void
    {
        if (!$value instanceof RouteConfig) {
            throw new InvalidArgumentException('Value must be instance of RouteConfig.');
        }
    }
}
