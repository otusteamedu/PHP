<?php

namespace App\Domain;

use App\App;
use InvalidArgumentException;
use JsonException;
use Spiral\Goridge\RPC;

class PublisherRPC implements PublisherInterface
{
    protected RPC $rpc;

    public function __construct(RPC $rpc)
    {
        $this->rpc = $rpc;
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
        $this->rpc->call(
            'jobs.PushAsync',
            [
                'options' => ['pipeline' => App::get('pipeline')],
                'payload' => $payload,
            ]
        );
    }
}
