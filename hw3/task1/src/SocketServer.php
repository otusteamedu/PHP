<?php
/**
* Socket class inheritor to create and work with socket as a server
*
* @author Evgeny Prokhorov <contact@jekys.ru>
*/
namespace Jekys;

class SocketServer extends Socket
{
    /**
    * @var resource $res - socket handler
    */
    private $res;

    /**
    * @var resource $socket - socket connection with client
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
        $this->res = socket_create(AF_INET, SOCK_STREAM, 0);
        if ($this->res) {
            socket_bind($this->res, $host, $port);
            socket_listen($this->res, 1);
            $this->socket = socket_accept($this->res);
        }
    }

    /**
    * Returns last error from socket
    *
    * @return string
    */
    public function getLastResError()
    {
        return socket_strerror(socket_last_error($this->res));
    }

    /**
    * Object descructor. Closes all conections
    *
    * @return voide
    */
    public function __destruct()
    {
        socket_close($this->res);
        socket_close($this->socket);
    }
}
