<?php

declare(strict_types=1);

namespace Nlazarev\Hw2_1\Model\Collections\ClientsCon;

use Nlazarev\Hw2_1\Model\Collections\Generic\CollectionGeneric;
use Nlazarev\Hw2_1\Model\ServerManager\ClientCon\IClientCon;

final class CollectionClientsCon extends CollectionGeneric implements ICollectionClientsCon
{
    public function __construct(IClientCon ...$clients)
    {
        $this->values = $clients;
    }

    public function addClient(IClientCon $client)
    {
        $this->push($client);
    }
}
