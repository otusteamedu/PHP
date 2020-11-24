<?php

declare(strict_types=1);

namespace Nlazarev\Hw2_1;

use Noodlehaus\Config;
use Nlazarev\Hw2_1\Model\Sockets\SocketServer;
use Nlazarev\Hw2_1\Model\Clients\ClientSocketCli;
use Nlazarev\Hw2_1\Model\Collections\CollectionClients;

final class AppServerSocket
{
    private static string $conf_path = "../config/server.json";
    private static Config $conf;
    private static SocketServer $socket;
    private static CollectionClients $clients;

    public static function run()
    {
        static::$conf = new Config(static::$conf_path);
        static::$socket = new SocketServer();
        static::$clients = new CollectionClients();

        if (!static::$socket->isCreated()) {
            exit;
        }

        static::setParams();

        if (!static::$socket->bind((string) static::$conf->get('server.unix.socket_address'))) {
            exit;
        }

        if (!static::$socket->listen((int) static::$conf->get('server.unix.cli.listen.backlog'))) {
            exit;
        }

        if (!static::$socket->set_nonblock()) {
            exit;
        }

        static::goCliMsg();
    }

    private static function setParams()
    {
        static::$socket->setMaxClientsCount((int) static::$conf->get('server.unix.cli.max_clients'))
            ->setCheckTimeout((int) static::$conf->get('server.unix.cli.check.timeout'))
            ->setReadBuf((int) static::$conf->get('server.unix.cli.read.buf'))
            ->setReadType((int) static::$conf->get('server.unix.cli.read.type'));
    }

    private static function goCliMsg()
    {
        echo "Waiting for clients connections.. \n";

        $socket = static::$socket->getInstance();
        $write = $except = null;

        while (true) {
            $read = array($socket);
            foreach (static::$clients as $key => $client) {
                $read[] = $client->getInstance();
            }
        }

        if (static::$socket->getChangesCount($read, $write, $except) == 0) {
            continue;
        }

        // when new client trying to connect
        if (in_array($socket, $read)) {
            if (!is_null($new_client_con = static::$socket->acceptConnection())) {
                if (static::$clients->count() < static::$socket->getMaxClientsCount()) {
                    if (static::$socket->writeMsg($new_client_con, "[Server] You are connecting \n") > 0) {
                        static::$clients->set(static::$clients->key_last() + 1, new ClientSocketCli($new_client_con));
                    } else {
                        static::$socket->shutdownClient($new_client_con);
                    }
                } else {
                    if (static::$socket->writeMsg($new_client_con, "[Server] No more free connections \n") == 0) {
                        static::$socket->shutdownClient($new_client_con);
                    }
                }
            }
        }

        // loop all clients for new data
        foreach (static::$clients as $key => $client) {
            if (in_array($client->getInstance(), $read)) {
                if (!is_null(static::$socket->readMsg($client->getInstance()))) {
                    if (static::$socket->writeMsg($client->getInstance(), "[Server] Message received \n") == 0) {
                        static::$socket->shutdownClient($client->getInstance());
                        static::$clients->unset($key);
                        //$client->disconnect();
                    }
                } else {
                    if (static::$socket->writeMsg($client->getInstance(), "[Server] Message not received \n") == 0) {
                        static::$socket->shutdownClient($client->getInstance());
                        static::$clients->unset($key);
                        //$client->disconnect();
                    }
                }
            }
        }

        echo static::$clients->count() . " (of max " . static::$socket->getMaxClientsCount() . ") clients connected \n";
    }
}
