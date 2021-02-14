<?php

declare(strict_types=1);

namespace Nlazarev\Hw2_1\Model\ServerManager;

interface IServerManager
{
    public function getServerInstance();
    public function init();
    public function run();
}
