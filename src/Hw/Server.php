<?php
namespace Hw4;

use League\CLImate\CLImate;

final class Server extends Socket {

    private $climate;

    public function __construct() {
        if (empty($socketLocation = (parse_ini_file(__DIR__ . "/../../etc/config.ini"))['server_file']))
            throw new \Exception("Error Processing Config File");
        // wipe old file
        @unlink($socketLocation);
        parent::__construct();
        $this->setSocketFileLocation($socketLocation);
        $this->climate = new CLImate;
    }

    public function run() {
        $this->bind();
        while ($a = true) {
            $this->climate->lightGray("Waiting fo messages ...");
            $this->setBlocking(true);
            $from = '';
            $buf = $this->recvFrom($length = 1024, $from);
            $this->climate->backgroundLightYellow()->black(" >> Message recieved: $buf");
            $responce = "got it";
            $this->setBlocking(false);
            $this->sendTo($responce, $from);
        }
    }
}