<?php

declare(strict_types=1);

namespace App\Service\Queue;

interface ConsumerInterface
{
    public function consume(QueueMessage $message): void;
}