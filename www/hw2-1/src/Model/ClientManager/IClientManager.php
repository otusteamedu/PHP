<?php

declare(strict_types=1);

namespace Nlazarev\Hw2_1\Model\ClientManager;

interface IClientManager
{
    public function getClientInstance();
    public function init();
    public function run();
}
