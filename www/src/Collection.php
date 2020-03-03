<?php

namespace Tirei01\Hw12;

abstract class Collection implements \Iterator
{

    protected $mapper;
    protected $total = 0;
    protected $raw = array();

    private $pointer = 0;
    private $objects = array();

    public function __construct(array $raw = array(), Mapper $mapper = null)
    {
        $this->raw = $raw;
        $this->total = count($raw);

        $this->mapper = $mapper;
    }

    public function add(DomainObject $object)
    {
        $this->notifyAccess();
        $this->objects[$this->total] = $object;
        $this->total++;
    }

    abstract public function targetClass(): string;

    protected function notifyAccess()
    {

    }

    private function getRow($num)
    {
        $this->notifyAccess();
        if ($num >= $this->total || $num < 0) {
            return null;
        }
        if (isset($this->objects[$num])) {
            return $this->objects[$num];
        }
        if (isset($this->raw[$num])) {
            $this->objects[$num] = $this->mapper->createObject($this->raw[$num]);
            return $this->objects[$num];
        }
        return null;
    }

    /**
     * @inheritDoc
     */
    public function current()
    {
        return $this->getRow($this->pointer);
    }

    /**
     * @inheritDoc
     */
    public function next()
    {
        $row = $this->getRow($this->pointer);
        if (!is_null($row)) {
            $this->pointer++;
        }
    }

    /**
     * @inheritDoc
     */
    public function key()
    {
        return $this->pointer;
    }

    /**
     * @inheritDoc
     */
    public function valid()
    {
        return (!is_null($this->current()));
    }

    /**
     * @inheritDoc
     */
    public function rewind()
    {
        $this->pointer = 0;
    }
}