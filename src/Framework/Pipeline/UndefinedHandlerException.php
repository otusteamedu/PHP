<?php

namespace Framework\Pipeline;

class UndefinedHandlerException extends \InvalidArgumentException
{
    /**
     * @param string $handler
     */
    public function __construct(string $handler)
    {
        parent::__construct("Undefined a handler {$handler}");
    }
}
