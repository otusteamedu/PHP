<?php
namespace Hw4;

use League\CLImate\CLImate;

final class Client extends Socket {

    private $climate;

    public function __construct() {
        if (empty($socketLocation = (parse_ini_file(__DIR__ . "/../../etc/config.ini"))['client_file']))
            throw new \Exception("Error Processing Config File");
        // wipe old file
        @unlink($socketLocation);
        parent::__construct();
        $this->setSocketFileLocation($socketLocation);
        $this->climate = new CLImate;
    }

    public function run() {
        $this->bind();
        $this->setBlocking(false);

        $serverSideSock = (parse_ini_file(__DIR__ . "/../../etc/config.ini"))['server_file'];

        while ($a = true) {
            $message = readline("Send message to socket server: ");
            if ($message == "exit") {
                $this->close();
                exit;
            }

            $this->sendTo($message, $serverSideSock);
            $this->setBlocking(true);

            $from = '';
            $buf = $this->recvFrom($lenght = 1024, $from);
            $this->climate->backgroundLightGreen()->black(" >> Received responce: $buf");
        }
    }
}