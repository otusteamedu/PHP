<?php

declare(strict_types=1);

namespace Nlazarev\Hw2_1;

use Nlazarev\Hw2_1\Model\ClientManager\ClientSocket\ClientManagerSocketCli;
use Nlazarev\Hw2_1\Model\ClientManager\ClientSocket\IClientManagerSocketCli;
use Nlazarev\Hw2_1\Model\Config\ConfigFileJson;
use Nlazarev\Hw2_1\Model\Config\IConfig;
use Nlazarev\Hw2_1\Model\Sockets\ISocketClient;
use Nlazarev\Hw2_1\Model\Sockets\SocketClient;
use Nlazarev\Hw2_1\Model\Viewers\IViewer;
use Nlazarev\Hw2_1\Model\Viewers\ViewerCli;

final class AppClientSocket
{
    private static string $conf_path = "../config/client.json";
    private static IConfig $conf;
    private static ISocketClient $socket;
    private static IClientManagerSocketCli $client;
    private static IViewer $info_viewer;

    public static function run()
    {
        static::$conf = new ConfigFileJson(static::$conf_path);
        static::$socket = new SocketClient();
        static::$info_viewer = new ViewerCli();

        static::$client = new ClientManagerSocketCli(static::$socket, static::$conf, static::$info_viewer);


        if (!static::$client->init()) {
            exit;
        }

        static::$client->run();
    }
}
