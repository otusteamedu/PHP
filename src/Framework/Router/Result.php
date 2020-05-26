<?php

namespace Framework\Router;

class Result
{
    /** @var string */
    private $name;

    /** @var mixed */
    private $handler;

    /** @var array */
    private $args;

    /**
     * @param string $name
     * @param mixed $handler
     * @param array $args
     */
    public function __construct(string $name, $handler, array $args)
    {
        $this->name = $name;
        $this->handler = $handler;
        $this->args = $args;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return mixed
     */
    public function getHandler()
    {
        return $this->handler;
    }

    /**
     * @return array
     */
    public function getArgs(): array
    {
        return $this->args;
    }
}
