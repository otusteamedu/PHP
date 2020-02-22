<?php

declare(strict_types=1);

namespace App\Order;

class IndividualOrder extends AbstractOrder implements OrderInterface
{
    public const TYPE = 'b2c';

    protected $client;

    public function __construct(array $data)
    {
        parent::__construct($data);
    }

    public function getClient()
    {
        return $this->client;
    }

    public function setClient($client)
    {
        $this->client = $client;
    }
}