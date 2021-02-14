<?php

declare(strict_types=1);

namespace Nlazarev\Hw2_1\Model\Collections\ClientsCon;

use Nlazarev\Hw2_1\Model\Collections\Generic\ICollectionGeneric;
use Nlazarev\Hw2_1\Model\ServerManager\ClientCon\IClientCon;

interface ICollectionClientsCon extends ICollectionGeneric
{
    public function __construct(IClientCon ...$clients);
    public function addClient(IClientCon $client);
}
