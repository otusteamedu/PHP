<?php


namespace models;


abstract class Socket
{
    protected $host;
    protected $sock;
    protected $domain;
    protected $type;
    protected $read_length;

    /**
     * Socket constructor.
     * @param string $host
     * @param int $domain
     * @param int $type
     * @param int $read_length
     * @throws \Exception
     */
    function __construct($host, $domain, $type, $read_length)
    {
        $this->host = $host;
        $this->domain = $domain;
        $this->type = $type;
        $this->read_length = $read_length;

        if (!$this->sock = socket_create($this->domain, $this->type, 0))
            throw new \Exception("Can`t create socket" . PHP_EOL);

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
     * Init method
     */
    protected abstract function init();

    /**
     * Run method
     */
    public abstract function run();

}