<?php
/**
* Class helper to connect and work with socket as a client
*
* @author Evgeny Prokhorov <contact@jekys.ru>
*/
namespace Jekys;

class Socket
{
    /**
    * @var resource $socket - socket handler
    */
    protected $socket;

    /**
    * ObjectConstructor
    *
    * @param string $host
    * @param string $port
    *
    * @return Socket
    */
    public function __construct(String $host, Int $port)
    {
        $this->socket = socket_create(AF_INET, SOCK_STREAM, 0);
        socket_connect($this->socket, $host, $port);
    }

    /**
    * Sends message to the socket
    *
    * @param string $msg
    *
    * @return boolean
    */
    public function sendMsg(String $msg)
    {
        $msg = $msg."\n";

        return socket_write($this->socket, $msg, strlen($msg));
    }

    /**
    * Reads msg from socket
    *
    * @return mixed
    */
    public function readMsg()
    {
        $msg = '';

        while (($bite = socket_read($this->socket, 1)) != "\n") {
            $msg .= $bite;
        }

        return $msg;
    }

    /**
    * Returns last error from socket
    *
    * @return string
    */
    public function getLastError()
    {
        return socket_strerror(socket_last_error($this->socket));
    }

    /**
    * Object descructor. Closes all conections
    *
    * @return voide
    */
    public function __destruct()
    {
        socket_close($this->socket);
    }
}
