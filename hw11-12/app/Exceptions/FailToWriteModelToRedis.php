<?php

namespace App\Exceptions;

use JetBrains\PhpStorm\Pure;

class FailToWriteModelToRedis extends \Exception implements RedisExceptionInterface
{
    /**
     * FailToWriteModelToRedis constructor.
     */
    #[Pure]
    public function __construct()
    {
        $previousMessageException = $this->getPrevious()?->getMessage() ?? 'unknown';
        parent::__construct("Some error has occurred while writing model to redis storage! Reason: {$previousMessageException}");
    }
}
