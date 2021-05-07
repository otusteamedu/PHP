<?php

namespace App\Exceptions;

use JetBrains\PhpStorm\Pure;

class FailToFindSpecifiedRecordInRedis extends \Exception implements RedisExceptionInterface
{
    /**
     * FailToFindSpecifiedRecordInRedis constructor.
     */
    #[Pure]
    public function __construct()
    {
        parent::__construct("Fail to find specified record in redis storage!");
    }
}
