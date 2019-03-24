<?php

namespace crazydope\calculator;

trait ExpressionListIteratorTrait
{
    public function current()
    {
        return current($this->list);
    }

    public function next()
    {
        return next($this->list);
    }

    public function key()
    {
        return key($this->list);
    }

    public function valid()
    {
        return key($this->list) !== null;
    }

    public function rewind()
    {
        return reset($this->list);
    }
}