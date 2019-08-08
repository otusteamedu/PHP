<?php

declare(strict_types=1);

namespace Otus\hw22\Mapper;

class Relation
{
    /**
     * @var MapperInterface
     */
    protected $mapper;

    /**
     * @var string
     */
    protected $method;

    /**
     * @var mixed
     */
    protected $args;

    /**
     * @var mixed
     */
    private $result;

    /**
     * @var int
     */
    private $called = false;

    public function __construct(MapperInterface $mapper, string $method, $args = null)
    {
        $this->mapper = $mapper;
        $this->method = $method;
        $this->args = $args;
    }

    public function setArgs($args)
    {
        $this->args = $args;
    }

    public function __invoke()
    {
        if (!$this->called) {
            $this->setResult(call_user_func_array([
                $this->mapper,
                $this->method
            ], [$this->args]));
        }

        return $this->result;
    }

    public function setResult($result): void
    {
        $this->result = $result;
        $this->called = true;
    }

}