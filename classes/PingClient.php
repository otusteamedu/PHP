<?php

require_once "classes/SocketService.php";
require_once "classes/PongService.php";
require_once "classes/SocketConfig.php";

class PingClient extends SocketService
{
    /**
     * PingClient constructor.
     * @param SocketConfig $config
     * @throws Exception
     */
    public function __construct(SocketConfig $config)
    {
        parent::__construct($config);
        if (!socket_bind($this->source, $this->config->clientAddress)) $this->socketError();
        if (!file_exists($this->config->serverAddress)) {
            $this->close();
            throw new Exception("run Pong service first");
        }
    }

    /**
     * @param string $message
     * @return string
     * @throws Exception
     */
    public function send(string $message): string
    {
        $this->sendTo($message, $this->config->serverAddress);
        usleep($this->config->clientDelay);
        $response = $this->receiveFrom($addr);
        return $response;
    }

    public function close()
    {
        socket_close($this->source);
        unlink($this->config->clientAddress);
    }
}