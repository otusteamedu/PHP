<?php

declare(strict_types=1);

namespace App\Queue\NewSuperMQ;

use App\Kernel\ClientCreatorInterface;
use App\Queue\QueueClientInterface;
use Exception;

class NewSuperMQCreator implements ClientCreatorInterface
{
    /**
     * @param array $config
     * @return object
     * @throws Exception
     */
    public static function create(array $config): QueueClientInterface
    {
        // TODO добавить параметры

        return new Client();
    }
}
