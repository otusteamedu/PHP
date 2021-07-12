<?php

namespace App;

class Server
{
    public static function start()
    {
        $config = Config::getConfig();

        if (file_exists($config['socket_path'])){
            unlink($config['socket_path']);
        }

        $socket = socket_create(AF_UNIX, SOCK_DGRAM, 0);

        if (!$socket) {
            die('Unable to create AF_UNIX socket');
        }

        $serverSideSock = $config['socket_path'];

        echo $serverSideSock."\n";

        if (!socket_bind($socket, $serverSideSock)) {
            die("Unable to bind to $serverSideSock");
        }

        while(true)
        {
            if (!socket_set_block($socket)){
                die('Unable to set blocking mode for socket');
            }

            $buf = '';

            echo "Ready to receive...\n";

            $bytesReceived = socket_recvfrom($socket, $buf, 65536, 0, $from);

            if ($bytesReceived == -1){
                die('An error occured while receiving from the socket');
            }

            echo "Received $buf client";
        }
    }
}