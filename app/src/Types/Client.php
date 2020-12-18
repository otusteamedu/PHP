<?php

namespace Types;
use Config\Config;

class Client {
    public static function start()
    {

        $config = Config::getConfig();
    
        $socket = socket_create(AF_UNIX, SOCK_DGRAM, 0);
        socket_sendto($socket, "Hello World!", 12, 0, $config['socket_path'], 0);
        echo "sent\n";
    }
}
