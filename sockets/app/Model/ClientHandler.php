<?php

namespace App\Model;

use App\Api\LoggerInterface;
use Socket\Raw\Socket;

class ClientHandler
{
    /**
     * @var LoggerInterface
     */
    private LoggerInterface $logger;

    public function __construct(LoggerInterface $logger)
    {
        $this->logger = $logger;
    }

    public function execute(Socket $socket, $command, $parameters)
    {
        $result = $socket->read(2048);
        if ($result == 'Hello') {
            $this->logger->writeln("Connected ");
            $cmd = implode(' ', array_filter([$command, $parameters]));
            if (!$cmd) {
                $cmd = 'list';
            }
            $this->logger->writeln("Send command {$cmd}");
            $socket->write($cmd);
            $result = $socket->read(2048);
            $this->logger->writeln("Response: ".print_r($result, true));
        } else {
            $this->logger->writeln("Unknown server response {$result}");
        }
        $socket->close();
    }
}