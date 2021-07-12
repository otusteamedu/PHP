<?php

namespace App;

class App
{
    public function __construct()
    {
        if (php_sapi_name() !== 'cli') {
            throw new \Exception('run it in cli');
        }
    }

    /**
     * @param $argv
     * @throws \Exception
     */
    public function run($argv)
    {
        switch ($argv[1]) {
            case 'server':
                Server::start();
                break;
            case 'client':
                Client::start();
                break;
            default:
                throw new \Exception('incorrect type');
        }
    }
}