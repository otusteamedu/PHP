<?php

namespace nvggit;

/**
 * Class Server
 * @package nvggit
 */
class Server
{
    const PORT_DEFAULT = 4550;
    const HOST_DEFAULT = "127.0.0.1";
    const MAX_CLIENT_COUNT_DEFAULT = 5;

    public $host;
    public $port;
    public $clientCount;
    private $socket;
    private $onlineClients;

    /**
     * Server constructor.
     * @param null $host
     * @param null $port
     * @param null $clientCount
     */
    public function __construct($host = null, $port = null, $clientCount = null)
    {
        $this->host = !empty($host) ? $host : self::HOST_DEFAULT;
        $this->port = !empty($port) ? $port : self::PORT_DEFAULT;
        $this->clientCount = !empty($clientCount) ? $clientCount : self::MAX_CLIENT_COUNT_DEFAULT;
        $this->onlineClients = array();
    }

    public static function prepareSysMsg($msg)
    {
        return "[" . date("d-m-Y H:i:s", time()) . "] $msg\n";
    }

    /**
     * start server
     */
    public function start()
    {
        $this->socket = socket_create(AF_INET, SOCK_STREAM, SOL_TCP) or die(socket_strerror());
        socket_bind($this->socket, $this->host, $this->port) or die($this->getSocketError());
        socket_listen($this->socket, $this->clientCount) or die($this->getSocketError());

        echo self::prepareSysMsg("Server host: $this->host port: $this->port started!");

        $this->listen();
    }

    public function listen()
    {
        while (true) {
            $accept = socket_accept($this->socket);

            $this->onlineClients[]['socket'] = $accept;
            echo self::prepareSysMsg("New colonist #" . $this->getClientId($accept) . " connected");
            socket_write($accept, $this->getWelcomeMsg());
            $clientId = $this->getClientId($accept);
            socket_write($accept, $this->getRegisatrationMsg($clientId));

            while ($accept) {
                $input = socket_read($accept, 1024) or die($this->getSocketError());
                echo self::prepareSysMsg("New message recieved from client #" . $this->getClientId($accept) . " $input");

                $this->setAnswer($clientId, $input);

                socket_write($accept, $this->getRegisatrationMsg($clientId));

                if ($this->isClientFinishRegistration($clientId)) {
                    $this->closeConnection($clientId);
                    echo self::prepareSysMsg("Client #" . $clientId . " connection closed!");
                    break;
                }
            }
        }
    }

    public function isClientFinishRegistration($clientId): bool
    {
        return isset($this->onlineClients[$clientId]['finish']) && $this->onlineClients[$clientId]['finish'] === 1;
    }

    public function closeConnection($clientId)
    {
        socket_close($this->onlineClients[$clientId]['socket']);
        unset($this->onlineClients[$clientId]);
    }

    public function getSocketError(): string
    {
        return socket_strerror(socket_last_error($this->socket)) . "\n";
    }

    public function getClientId($client)
    {
        $id = null;
        foreach ($this->onlineClients as $onlineClientKey => $onlineClient) {
            if ($onlineClient['socket'] === $client) {
                $id = $onlineClientKey;
            }
        }
        return $id;
    }

    public function setAnswer($clientId, $answer)
    {
        $client = $this->onlineClients[$clientId];
        if (!isset($client['name'])) {
            $this->onlineClients[$clientId]['name'] = $answer;
        } elseif (!isset($client['age'])) {
            $this->onlineClients[$clientId]['age'] = $answer;
            $this->onlineClients[$clientId]['finish'] = 1;
        }
    }

    public function getRegisatrationMsg($clientId): string
    {
        $client = $this->onlineClients[$clientId];

        if (!isset($client['name'])) {
            $out = "Please, enter your name:";
        } elseif (!isset($client['age'])) {
            $out = "Please, enter your age:";
        } else {
            $out = "Thank you for registration in SpaceX! We will contact you soon! Bye!";
        }
        return $out;
    }

    public function getWelcomeMsg(): string
    {
        return "/************\tWelcome to SpaceX registration!\t************/\n\n" .
            "\tOnline registration to Mars visit! Please,\n\ttell us some more information about you.\n\n"
            . "\tWe need " . self::MAX_CLIENT_COUNT_DEFAULT . " colonist to this fly.\n\n"
            . "/" . str_repeat("*", 59) . "/\n\n\r";
    }
}