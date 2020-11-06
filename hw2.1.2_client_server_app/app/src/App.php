<?php

namespace App;

use Symfony\Component\Dotenv\Dotenv;

class App
{
    private string $command = "";
    private string $socketFile;

    function __construct()
    {
        if (isset($_SERVER['argv'][1])) {
            $this->command = $_SERVER['argv'][1];
        }
        $dotenv = new Dotenv();
        $dotenv->load(__DIR__ . '/../.env');
        $this->socketFile = $_ENV['SOCKET_FILE'];
    }


    public function run(): void
    {
        switch ($this->command) {
            case "server":
                $this->runServer();
                break;
            case "client":
                $this->runClient();
                break;
            default:
                $this->showHelp();
        }

    }


    private function showHelp(): void
    {
        echo "php app.php [команда]\nКоманды:\n    server - Запуск сервера\n    client - Запуск клиента\n";
    }


    private function runServer(): void
    {
        echo "Запуск сервера... \n";
        $server = new Server($this->socketFile);
        $server->runDaemon();
    }


    private function runClient(): void
    {
        echo "Запуск клиента\n";
        $client = new Client($this->socketFile);
        $client->runDaemon();
    }

}