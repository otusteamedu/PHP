<?php

namespace crazydope\calculator\Exceptions;

interface AddExceptionInterface
{
    public function add(\Throwable $e);
}