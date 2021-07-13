<?php

namespace App;

class App
{
    public function __construct()
    {
        if (php_sapi_name() !== 'cli') {
            throw new AppException('run it in cli');
        }
    }

    /**
     * @param $argv
     * @throws \Exception
     */
    public function run($argv): void
    {
        switch ($argv[1]) {
            case 'server':
                (new Server())->start();
                break;
            case 'client':
                Client::start();
                break;
            default:
                throw new AppException('incorrect type');
        }
    }
}