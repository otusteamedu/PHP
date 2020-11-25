<?php

namespace Otus\Http;

use Otus\Config\Config;
use Otus\Queue\ConnectionFactory;

class QueueController
{
    public function store(Request $request): ResponseContract
    {
        $config     = Config::getInstance();
        $connection = ConnectionFactory::make($config);
        $queue      = $connection->connect($config);
        $queue->push($config->get('queues.rabbitmq.queue'), 'Hello world!');

        return new JsonResponse(Response::HTTP_CREATED);
    }
}
