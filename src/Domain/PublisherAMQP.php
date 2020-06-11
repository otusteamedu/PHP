<?php

namespace App\Domain;

use AMQPExchange;
use App\App;
use InvalidArgumentException;
use JsonException;

class PublisherAMQP implements PublisherInterface
{
    protected AMQPExchange $exchange;

    public function __construct(AMQPExchange $exchange)
    {
        $this->exchange = $exchange;
    }

    public function publish(string $id, $data): void
    {
        try {
            $payload = json_encode(
                [
                    'id' => $id,
                    'data' => $data,
                ],
                JSON_THROW_ON_ERROR
            );
        } catch (JsonException $e) {
            throw new InvalidArgumentException('Serialization error');
        }
        $headers = [
            'headers' => [
                'rr-id' => $id,
                'rr-job' => 'local.test',
                'rr-attempt' => 0,
                'rr-maxAttempts' => 0,
                'rr-delay' => 0,
                'rr-retryDelay' => 0,
                'rr-timeout' => 0,
            ],
        ];
        /** @noinspection PhpUnhandledExceptionInspection */
        $this->exchange->publish($payload, App::get('exchange'), AMQP_MANDATORY, $headers);
    }
}
