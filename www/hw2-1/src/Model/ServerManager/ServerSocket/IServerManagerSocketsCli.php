<?php

declare(strict_types=1);

namespace Nlazarev\Hw2_1\Model\ServerManager\ServerSocket;

use Nlazarev\Hw2_1\Model\ServerManager\IServerManager;

interface IServerManagerSocketsCli extends IServerManager
{
    public function getServerState();
    public function init(): bool;
    public function info(string $msg);
    public function getMaxClientsCount(): int;
    public function setMaxClientsCount(int $max_clients);
}
