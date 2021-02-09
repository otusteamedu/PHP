<?php

declare(strict_types=1);

namespace Nlazarev\Hw2_1\Model\ClientManager\ClientSocket;

use Nlazarev\Hw2_1\Model\ClientManager\IClientManager;
use Nlazarev\Hw2_1\Model\Config\IConfig;
use Nlazarev\Hw2_1\Model\Sockets\ISocketClient;
use Nlazarev\Hw2_1\Model\Viewers\IViewer;

interface IClientManagerSocketCli extends IClientManager
{
    public function __construct(ISocketClient $socket_client, IConfig $conf, IViewer $info_viewer);
    public function init(): bool;
    public function info(string $msg);
}
