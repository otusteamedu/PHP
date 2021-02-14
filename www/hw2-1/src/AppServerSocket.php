<?php

declare(strict_types=1);

namespace Nlazarev\Hw2_1;

use Nlazarev\Hw2_1\Model\Collections\ClientsCon\CollectionClientsCon;
use Nlazarev\Hw2_1\Model\Collections\ClientsCon\ICollectionClientsCon;
use Nlazarev\Hw2_1\Model\Config\ConfigFileJson;
use Nlazarev\Hw2_1\Model\Config\IConfig;
use Nlazarev\Hw2_1\Model\ServerManager\ServerSocket\IServerManagerSocketsCli;
use Nlazarev\Hw2_1\Model\ServerManager\ServerSocket\ServerManagerSocketsCli;
use Nlazarev\Hw2_1\Model\Sockets\ISocketServer;
use Nlazarev\Hw2_1\Model\Sockets\SocketServer;
use Nlazarev\Hw2_1\Model\Viewers\IViewer;
use Nlazarev\Hw2_1\Model\Viewers\ViewerCli;

final class AppServerSocket
{
    private static string $conf_path = "../config/server.json";
    private static IConfig $conf;
    private static ISocketServer $server;
    private static IServerManagerSocketsCli $server_manager;
    private static ICollectionClientsCon $clients_con;
    private static IViewer $info_viewer;

    public static function run()
    {
        static::$conf = new ConfigFileJson(static::$conf_path);
        static::$server = new SocketServer();
        static::$clients_con = new CollectionClientsCon();
        static::$info_viewer = new ViewerCli();

        static::$server_manager = new ServerManagerSocketsCli(
            static::$server,
            static::$clients_con,
            static::$conf,
            static::$info_viewer
        );

        if (!static::$server_manager->init()) {
            exit;
        }

        static::$server_manager->run();
    }
}
