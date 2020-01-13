<?php


namespace Ushakov;

use \Exception;


class App
{
    protected $socketFile;
    protected $instance;

    public function __construct()
    {
        $this->socketFile = __DIR__ . getenv('SOCKET_FILE');
        $argv = $_SERVER['argv'];
        if (count($argv) !== 2) {
            echo 'Wrong args' . PHP_EOL;
            exit(1);
        }
        $this->instance = $argv[1];
    }


    public function run()
    {
        switch ($this->instance) {
            case 'server':
                $this->runServer();
                break;
            case 'client':
                $this->runClient();
                break;
            default:
                echo 'You have to specify what you want to run: client or server' . PHP_EOL;
                exit(1);
        }
    }


    protected function runServer()
    {
        try {
            $server = new Server($this->socketFile);
            echo "Waiting for new connection" . PHP_EOL;
            $server->waitForClient();
            echo "Got new connection" . PHP_EOL;
            $i = 0;
            while (($clientMessage = $server->receiveMessage()) !== Server::QUIT_MESSAGE) {
                echo "Received message: " . $clientMessage;
                $server->sendMessage((++$i) . " messages were received");
            }
            echo "Client has closed connection." . PHP_EOL;
            $server->closeConnection();
        } catch (Exception $exception) {
            echo "Server error: " . $exception->getMessage() . PHP_EOL;
        }

    }

    protected function runClient()
    {
        try {
            $client = new Client($this->socketFile);
            while (strlen($message = readline("Enter your message or leave it blank to close: " . PHP_EOL . "> ")) > 0) {
                $client->sendMessage($message);
                $serverMessage = $client->receiveMessage();
                echo "Server: " . $serverMessage;
            }
            $client->closeConnection();
            echo "Connection was successfully closed" . PHP_EOL;
        } catch (Exception $exception) {
            echo "Client error: " . $exception->getMessage() . PHP_EOL;
        }
    }
}
