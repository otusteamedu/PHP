<?php

declare(strict_types=1);

namespace App\Queue;

interface QueueClientCreatorInterface
{
    public static function create(array $config): QueueClientInterface;
}