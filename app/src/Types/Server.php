<?php

namespace Types;
use Config\Config;

class Server {
    public static function start()
    {
        $config = Config::getConfig();

        if (file_exists($config['socket_path'])){
            unlink($config['socket_path']);
        }

        // create unix udp socket
        $socket = socket_create(AF_UNIX, SOCK_DGRAM, 0);

        if (!$socket) {
            die('Unable to create AF_UNIX socket');
        }

        // same socket will be used in recv_from and send_to
        $server_side_sock = $config['socket_path'];
        echo $server_side_sock."\n";
        if (!socket_bind($socket, $server_side_sock)) {
            die("Unable to bind to $server_side_sock");
        }

        while(1) // server never exits
        {
            // receive query
            if (!socket_set_block($socket)){
                die('Unable to set blocking mode for socket');
            }

            $buf = '';

            echo "Ready to receive...\n";

            // will block to wait client query
            $bytes_received = socket_recvfrom($socket, $buf, 65536, 0, $from);

            if ($bytes_received == -1){
                die('An error occured while receiving from the socket');
            }

            echo "Received $buf client";
        }
    }
}

