<?php

declare(strict_types=1);

namespace Nlazarev\Hw2_1\Model\ServerManager\ClientCon;

final class ClientCon implements IClientCon
{
    private $instance = null;

    public function __construct($instance)
    {
        $this->instance = $instance;
    }

    public function getInstance()
    {
        return $this->instance;
    }
}
