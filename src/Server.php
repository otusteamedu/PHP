<?php

class Server
{
    /**
     * @var Socket
     */
    private $socket;

    /**
     * @var string
     */
    private $clientAddress;

    /**
     * Server constructor.
     * @param string $address
     * @param string $clientAddress
     * @throws Exception
     */
    public function __construct(string $address, string $clientAddress)
    {
        $this->socket = new Socket($address);
        $this->clientAddress = $clientAddress;
    }

    /**
     * @return Generator
     * @throws Exception
     */
    public function run(): Generator
    {
        $this->socket->bind();
        while (true) {
            $this->socket->setBlock();
            list($buf, $from) = $this->socket->get();
            $receiveMsg = "Receive $buf from $from";
            yield $receiveMsg;
            $this->socket->setNonblock();
            $this->socket->send('Got message ' . $buf, $from);
        }
        $this->socket->close();
    }
}