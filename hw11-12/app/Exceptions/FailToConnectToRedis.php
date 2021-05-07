<?php

namespace App\Exceptions;

use JetBrains\PhpStorm\Pure;

class FailToConnectToRedis extends \Exception implements RedisExceptionInterface
{
    /**
     * FailToConnectToRedis constructor.
     */
    #[Pure]
    public function __construct()
    {
        $previousMEssageException = $this->getPrevious()?->getMessage() ?? 'unknown';
        parent::__construct("Fail to connect to redis storage! Reason: {$previousMEssageException}");
    }
}
