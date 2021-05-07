<?php

namespace App\Exceptions;

use JetBrains\PhpStorm\Pure;

class FailToAuthorizeToRedis extends \Exception implements RedisExceptionInterface
{
    /**
     * FailToAuthorizeToRedis constructor.
     */
    #[Pure]
    public function __construct()
    {
        $previousMEssageException = $this->getPrevious()?->getMessage() ?? 'unknown';
        parent::__construct("Fail to authorize to redis storage! Reason: {$previousMEssageException}");
    }
}
