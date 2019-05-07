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
    private $clientData;

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
        socket_set_option($this->socket, SOL_SOCKET, SO_REUSEADDR, 1);
        socket_bind($this->socket, $this->host, $this->port) or die($this->getSocketError());
        socket_listen($this->socket, $this->clientCount) or die($this->getSocketError());

        echo self::prepareSysMsg("Server host: $this->host port: $this->port started!");

        $this->listen();
    }

    public function listen()
    {
        $this->onlineClients = array($this->socket);
        while (true) {
            $read = $this->onlineClients;
            if (socket_select($read, $write = NULL, $except = NULL, 0) < 1)
                continue;

            if (in_array($this->socket, $read)) {
                $this->onlineClients[] = $newsock = socket_accept($this->socket);
                $clientId = $this->getClientId($newsock);

                socket_write($newsock, $this->getWelcomeMsg());
                socket_write($newsock, $this->getRegisatrationMsg($clientId));

                socket_getpeername($newsock, $ip);
                echo self::prepareSysMsg("New client connected: {$ip}");

                $key = array_search($this->socket, $read);
                unset($read[$key]);
            }

            foreach ($read as $read_sock) {
                $data = @socket_read($read_sock, 1024, PHP_NORMAL_READ);

                if ($data === false) {
                    $key = array_search($read_sock, $this->onlineClients);
                    unset($this->onlineClients [$key]);
                    echo "client disconnected.\n";
                    continue;
                }

                $data = trim($data);

                if (!empty($data)) {
                    echo self::prepareSysMsg("Msg from client: {$data}");
                    $this->setAnswer($clientId, $data);
                    socket_write($newsock, $this->getRegisatrationMsg($clientId));
                }
            }
        }
        socket_close($this->socket);
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
            if ($onlineClient === $client) {
                $id = $onlineClientKey;
            }
        }
        return $id;
    }

    public function setAnswer($id, $answer)
    {
        if (!isset($this->clientData[$id]['name'])) {
            $this->clientData[$id]['name'] = $answer;
        } elseif (!isset($this->clientData[$id]['age'])) {
            $this->clientData[$id]['age'] = $answer;
            $this->clientData[$id]['finish'] = 1;
        }
    }

    public function getRegisatrationMsg($id): string
    {
        $out = "Thank you for registration in SpaceX! We will contact you soon! Bye!";
        if (!isset($this->clientData[$id]['name'])) {
            $out = "Please, enter your name:";
        } elseif (!isset($this->clientData[$id]['age'])) {
            $out = "Please, enter your age:";
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