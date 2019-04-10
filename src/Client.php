<?php

namespace nvggit;

/**
 * Class Client
 * @package nvggit
 */
class Client
{
    const PORT_DEFAULT = 4550;
    const HOST_DEFAULT = "127.0.0.1";

    public $host;
    public $port;
    public $connect;
    public $socket;

    /**
     * Client constructor.
     */
    public function __construct()
    {
        $this->host = !empty($host) ? $host : self::HOST_DEFAULT;
        $this->port = !empty($port) ? $port : self::PORT_DEFAULT;
    }

    public function connect()
    {
        $this->socket = socket_create(AF_INET, SOCK_STREAM, SOL_TCP) or die($this->getSocketError());
        $this->connect = socket_connect($this->socket, $this->host, $this->port) or die($this->getSocketError());
    }

    /**
     * start client app
     */
    public function start()
    {
        $this->connect();

        if (!$this->connect) {
            socket_close($this->socket);
            exit;
        }
        while ($this->connect) {
            $read = socket_read($this->socket, 1024);
            if($read ===  false)
                break;
            echo "$read ";
            $input = fgets(STDIN);
            socket_write($this->socket, $input);
            echo "\n";
        }
        $this->closeConnection();
    }

    public function closeConnection()
    {
        echo "Connection closed.\n";
        socket_shutdown($this->socket);
        socket_close($this->socket);
        exit;
    }

    /**
     * @return string
     */
    public function getSocketError(): string
    {
        return socket_strerror(socket_last_error($this->socket)) . "\n";
    }

}