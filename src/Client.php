<?php

class Client
{
    /**
     * @var Socket
     */
    private $socket;
    /**
     * @var string
     */
    private $serverAddress;

    /**
     * Client constructor.
     * @param string $address
     * @param string $serverAddress
     * @throws Exception
     */
    public function __construct(string $address, string $serverAddress)
    {
        $this->socket = new Socket($address);
        $this->serverAddress = $serverAddress;
    }

    /**
     * @return Generator
     * @throws Exception
     */
    public function run(): Generator
    {
        $this->socket->bind();
        while (false !== ($msg = fgets(STDIN))) {
            $msg = trim($msg);
            if ($msg === 'exit') {
                break;
            }
            if ($msg) {
                $this->socket->setNonblock();
                $this->socket->send($msg, $this->serverAddress);
                $this->socket->setBlock();
                list($buf, $from) = $this->socket->get();
                $receiveMsg = "Receive $buf from $from";
                yield $receiveMsg;
            }
        }
        $this->socket->close();
    }
}