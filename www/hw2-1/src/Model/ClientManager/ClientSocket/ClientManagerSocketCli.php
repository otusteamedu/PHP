<?php

declare(strict_types=1);

namespace Nlazarev\Hw2_1\Model\ClientManager\ClientSocket;

use Nlazarev\Hw2_1\Model\Config\IConfig;
use Nlazarev\Hw2_1\Model\Sockets\ISocketClient;
use Nlazarev\Hw2_1\Model\Viewers\IViewer;

final class ClientManagerSocketCli implements IClientManagerSocketCli
{
    private ISocketClient $socket = null;
    private IConfig $conf;
    private IViewer $info_viewer;

    public function __construct(ISocketClient $socket_client, IConfig $conf, IViewer $info_viewer)
    {
        $this->socket = $socket_client;
        $this->conf = $conf;
        $this->info_viewer = $info_viewer;
    }

    public function init(): bool
    {
        if (!$this->socket->isCreated()) {
            return false;
        }

        if (!$this->socket->connect((string) $this->conf->getValueByKey('client.unix.socket_address'))) {
            return false;
        }

        return true;
    }

    public function run()
    {
        $this->info("Connected to " . (string) $this->conf->getValueByKey('client.unix.socket_address') . " - Done \n");
        $this->info("Type a message for send to the server [Enter] \n");
        $this->info("for exit, type '" . (string) $this->conf->getValueByKey('client.unix.cli.exit_string') . "' \n");

        $stdin = fopen("php://stdin", "r");

        $connected = true;

        while ($connected) {
            if (!is_null($answ = $this->socket->read($this->client->getInstance()))) {
                $this->info($answ . PHP_EOL);
            }

            $this->info("Message: ");

            $msg = fgets($stdin);

            $this->info(PHP_EOL);

            if ($msg == (string) $this->conf->getValueByKey('client.unix.cli.exit_string') . PHP_EOL) {
                $connected = false;
                fclose($stdin);
                $this->socket->close();
                continue;
            }

            $this->socket->write($this->socket->getInstance(), $msg);
        }
    }

    public function info(string $msg)
    {
        if (!is_null($this->info_viewer)) {
            $this->info_viewer->show($msg);
        }
    }

    public function getClientInstance()
    {
        return $this->socket;
    }
}
