<?php

namespace App;

use Socket\Socket;

/**
 * Class App
 * @package App
 *
 */
class App
{
    private bool $isClient = false;
    private bool $isServer = false;

    public function __construct($args)
    {
        switch ($args) {
            case 'server':
                $this->isServer = true;
                break;
            case 'client':
                $this->isClient = true;
                break;
            default:
                throw new \Exception('Can`t find arguments');
        }
    }

    public function run() {
        if ($this->isClient) {
            echo 'This is client' . PHP_EOL;
            $client = new \App\Client();
        } else if ($this->isServer) {
            echo 'This is server' . PHP_EOL;
            $server = new \App\Server();
        } else {
            throw new \Exception('Wrong init');
        }
    }
}