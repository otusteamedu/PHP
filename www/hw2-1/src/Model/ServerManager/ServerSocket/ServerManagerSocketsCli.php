<?php

declare(strict_types=1);

namespace Nlazarev\Hw2_1\Model\ServerManager\ServerSocket;

use Nlazarev\Hw2_1\Model\Collections\ClientsCon\ICollectionClientsCon;
use Nlazarev\Hw2_1\Model\Config\IConfig;
use Nlazarev\Hw2_1\Model\ServerManager\ClientCon\ClientCon;
use Nlazarev\Hw2_1\Model\Sockets\ISocketServer;
use Nlazarev\Hw2_1\Model\Viewers\IViewer;

final class ServerManagerSocketsCli implements IServerManagerSocketsCli
{
    private ISocketServer $server;
    private IConfig $conf;
    private ICollectionClientsCon $clients;
    private IViewer $info_viewer;
    private int $max_clients = 1;
    private int $state = 0;

    public function __construct(
        ISocketServer $socket_server,
        ICollectionClientsCon $clients_con,
        IConfig $conf,
        IViewer $info_viewer
    ) {
        $this->server = $socket_server;
        $this->conf = $conf;
        $this->info_viewer = $info_viewer;
        $this->clients = $clients_con;
    }

    public function init(): bool
    {
        if (!$this->server->isCreated()) {
            return false;
        }

        $this->setMaxClientsCount((int) $this->conf->getValueByKey('server.unix.cli.max_clients'));

        $this->server->setCheckTimeout((int) $this->conf->getValueByKey('server.unix.cli.check.timeout'));

        if (!$this->server->bind((string) $this->conf->getValueByKey('server.unix.socket_address'))) {
            return false;
        }

        if (!$this->server->listen((int) $this->conf->getValueByKey('server.unix.cli.listen.backlog'))) {
            return false;
        }

        if (!$this->server->setNonBlock()) {
            return false;
        }

        $this->state = 1;

        return true;
    }

    public function run()
    {
        $this->info("Waiting for clients connections.. \n");

        $server_sock = $this->server->getInstance();

        $this->state = 2;

        while (true) {
            $this->server->addSocketToRead($server_sock);
            foreach ($this->clients as $key => $client) {
                $this->server->addSocketToRead($client->getInstance());
            }

            if ($this->server->getChangesCount() == 0) {
                continue;
            }

            // when new client trying to connect
            if (in_array($server_sock, $this->server->getReadSockets())) {
                if (!is_null($new_client_con = $this->server->accept())) {
                    if ($this->clients->count() < $this->getMaxClientsCount()) {
                        if ($this->server->write($new_client_con, "[Server] You are connecting \n") > 0) {
                            $this->clients->addClient(new ClientCon($new_client_con));
                        } else {
                            $this->server->shutdownClient($new_client_con);
                        }
                    } else {
                        if ($this->server->write($new_client_con, "[Server] No more free connections \n") == 0) {
                            $this->server->shutdownClient($new_client_con);
                        }
                    }

                    $this->info($this->clients->count() . " of " . $this->getMaxClientsCount()
                        . "(max) clients connected \n");
                }
            }

            // loop all clients for new data
            foreach ($this->clients as $key => $client) {
                if (in_array($client->getInstance(), $this->server->getReadSockets())) {
                    if (!is_null($this->server->read($client->getInstance()))) {
                        if ($this->server->write($client->getInstance(), "[Server] Message received \n") == 0) {
                            $this->server->shutdownClient($client->getInstance());
                            $this->clients->unset($key);
                            $this->info($this->clients->count() . " of " . $this->getMaxClientsCount()
                                . "(max) clients connected \n");
                        }
                    } else {
                        if ($this->server->write($client->getInstance(), "[Server] Message not received \n") == 0) {
                            $this->server->shutdownClient($client->getInstance());
                            $this->clients->unset($key);
                            $this->info($this->clients->count() . " of " . $this->getMaxClientsCount()
                                . "(max) clients connected \n");
                        }
                    }
                }
            }
        }
    }

    public function info(string $msg)
    {
        if (!is_null($this->info_viewer)) {
            $this->info_viewer->show($msg);
        }
    }

    public function getServerInstance()
    {
        return $this->server;
    }

    protected function setServerState($state)
    {
        $this->state = $state;
    }

    public function getServerState()
    {
        return $this->state;
    }

    public function getMaxClientsCount(): int
    {
        return $this->max_clients;
        return $this;
    }

    public function setMaxClientsCount(int $max_clients)
    {
        $this->max_clients = $max_clients;
        return $this;
    }
}
