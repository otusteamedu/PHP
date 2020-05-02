<?php

namespace Bjlag;

use Psr\Container\ContainerInterface;

class Container implements ContainerInterface
{
    /** @var array */
    private $definitions = [];

    public function __construct(array $definitions)
    {
        $this->definitions = $definitions;
    }

    /**
     * @param string $id
     * @return mixed|object
     * @throws \ReflectionException
     */
    public function get($id)
    {
        $component = null;

        if (isset($this->definitions[$id])) {
            $definition = $this->definitions[$id];
        } else {
            $definition = $id;
        }

        if (is_string($definition)) {
            $class = new \ReflectionClass($id);
            $args = [];
            $constructor = $class->getConstructor();

            if ($constructor !== null) {
                $params = $constructor->getParameters();
                foreach ($params as $param) {
                    $paramClass = $param->getClass();
                    $args[] = $this->get($paramClass->getName());
                }
            }

            $component = $class->newInstanceArgs($args);
        } elseif (is_callable($definition)) {
            $component = call_user_func($definition, $this);
        }

        if ($component === null) {
            throw new \DomainException("Компонент {$id} не определен.");
        }

        return $component;
    }

    /**
     * @param string $id
     * @return bool
     */
    public function has($id)
    {
        /**
         * Из-за особенностей работы с контейнерами роутинга.
         * Надо возвращать TRUE. Метод get() сам разберется.
         */
        return true;
    }
}
