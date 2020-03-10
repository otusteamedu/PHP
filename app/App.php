<?php

namespace App;

class App
{
    public function run()
    {
        $option = getopt('cs');
        if (isset($option['s'])) {
            $server = new Server();
            $server->run();
        } elseif (isset($option['c'])) {
            $client = new Client();
            $client->run();
        } else {
            echo '-c запуск клиента' . PHP_EOL . '-s запуск сервера' . PHP_EOL;
        }
    }
}