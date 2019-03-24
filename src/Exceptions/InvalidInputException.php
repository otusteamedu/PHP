<?php

namespace crazydope\calculator\Exceptions;

class InvalidInputException
    extends \Exception
    implements \IteratorAggregate, \Countable, AddExceptionInterface

{
    protected $data = [];

    public function add( \Throwable $e )
    {
        $this->data[] = $e;
        $this->message .= $e->getMessage()."\n";
        return $this;
    }

    public function isEmpty(): bool
    {
        return empty($this->data);
    }

    public function toArray(): array
    {
        return array_map(function ( $value ) {
            return $value->getMessage();
        }, $this->data);
    }

    public function getIterator(): \ArrayIterator
    {
        return new \ArrayIterator($this->data);
    }

    public function count(): int
    {
        return count($this->data);
    }

    public function __toString()
    {
        return implode("\n", $this->toArray());
    }
}