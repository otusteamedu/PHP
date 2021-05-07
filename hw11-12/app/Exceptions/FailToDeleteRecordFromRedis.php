<?php

namespace App\Exceptions;

use JetBrains\PhpStorm\Pure;

class FailToDeleteRecordFromRedis extends \Exception implements RedisExceptionInterface
{
    /**
     * FailToDeleteRecordFromRedis constructor.
     */
    #[Pure]
    public function __construct()
    {
        $previousMEssageException = $this->getPrevious()?->getMessage() ?? 'unknown';
        parent::__construct("Fail to delete record from redis storage! Reason: {$previousMEssageException}");
    }
}
