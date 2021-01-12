<?php


namespace Server;


class Server
{
    public static function start() {

        if(!($socket = socket_create(AF_UNIX, SOCK_DGRAM, 0)))
        {
            $errorcode = socket_last_error();
            $errormsg = socket_strerror($errorcode);

            die("Couldn't create socket: [$errorcode] $errormsg \n");
        }

        echo "Socket created \n";

        // same socket will be used in recv_from and send_to
        $server_side_sock = "/sock/server.sock";
        echo $server_side_sock."\n";
        if (!socket_bind($socket, $server_side_sock)) {
            die("Unable to bind to $server_side_sock");
        }

        while(true) // server never exits
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