<?php

namespace Classes\Queue\Brokers;

use Classes\Queue\Brokers\RabbitBroker;

interface BrokersMap
{
    public const BROCKERS = [
        'rabbit' => RabbitBroker::class
    ];
}
