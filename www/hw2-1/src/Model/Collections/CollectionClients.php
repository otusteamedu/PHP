<?php

declare(strict_types=1);

namespace Nlazarev\Hw2_1\Model\Collections;

use Nlazarev\Hw2_1\Model\Clients\IClient;

final class CollectionClients extends CollectionGeneric
{
    public function __construct(IClient ...$clients)
    {
        $this->values = $clients;
    }

    public function getInstances()
    {
        foreach ($this->values as $key => $value) {
        }
    }

    public function newClient(IClient $client)
    {
    }

    public function isValidInstance($instance): bool
    {
        if (is_resource($instance)) {
            if (get_resource_type($instance) == 'Socket') {
                return true;
            }
        }

        return false;
    }
}
