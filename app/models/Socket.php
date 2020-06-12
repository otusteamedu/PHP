<?php


namespace models;


abstract class Socket
{
    const SOCKET_DOMAIN = AF_UNIX;
    const SOCKET_TYPE = SOCK_STREAM;
    const SOCKET_READ_LENGTH = 1024;

    protected $host;
    protected $sock;

    /**
     * Socket constructor.
     * @param $host
     * @throws \Exception
     */
    function __construct($host)
    {
        $this->host = $host;

        if (!$this->sock = socket_create(self::SOCKET_DOMAIN, self::SOCKET_TYPE, 0))
            throw new \Exception("Can`t create socket \n");

        $this->init();
    }

    /**
     *  Socket destructor.
     */
    function __destruct()
    {
        socket_close($this->sock);
    }

    /**
     * Init function
     */
    protected abstract function init();

}