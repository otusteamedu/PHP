<?php

namespace App\Exceptions;

use JetBrains\PhpStorm\Pure;

class ModelAlreadyExists extends \Exception implements RedisExceptionInterface
{
    /**
     * ModelAlreadyExists constructor.
     */
    #[Pure]
    public function __construct()
    {
        parent::__construct("Model with specified id already exists in a redis storage!");
    }
}
