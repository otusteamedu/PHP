<?php

require_once "classes/SocketService.php";
require_once "classes/PingClient.php";
require_once "classes/SocketConfig.php";

class PongService extends SocketService
{
    // можно было бы использовать адрес $this->config->clientAddress
    private $pingAddress = "";

    public function __construct(SocketConfig $config)
    {
        parent::__construct($config);
        if (!socket_bind($this->source, $this->config->serverAddress)) $this->socketError();
    }

    /**
     * @throws Exception
     */
    public function listen()
    {
        while (true) {
            echo "// waiting...", PHP_EOL;
            $message = $this->receiveFrom($this->pingAddress);
            echo "  >> $message", PHP_EOL;

            $responseMessage = $this->getResponse($message, $callback);
            $this->sendTo($responseMessage, $this->pingAddress);
            echo "  << {$responseMessage}", PHP_EOL;
            if (is_callable($callback)) {
                call_user_func($callback);
            }
            usleep($this->config->serverDelay);
        }
    }

    public function close()
    {
        echo "// shutting down", PHP_EOL;
        socket_close($this->source);
        unlink($this->config->serverAddress);
        exit;
    }

    /**
     * @param string $message
     * @param $callback
     * @return string
     */
    private function getResponse(string $message, &$callback): string
    {
        $response = "I got \"{$message}\". Keep going...";
        switch (strtolower(trim($message))) {
            case "" :
                return "Your message is empty. Send exit command to shut down Pong service, or try something else.";
            case strtolower($this->config->helloServer) :
                return "Hello, glad to see you...";
            case strtolower($this->config->exitCommand) :
                $callback = function () {
                    $this->close();
                };
                return "Pong service is shutting down... Bye!";
        }
        return $response;
    }
}