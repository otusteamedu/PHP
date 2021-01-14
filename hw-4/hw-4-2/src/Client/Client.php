<?php


namespace Client;

use Config\Config;

class Client
{
    public static function start()
    {
        //created socket
        if(!($socket = socket_create(AF_UNIX, SOCK_DGRAM, 0)))
        {
            $errorcode = socket_last_error();
            $errormsg = socket_strerror($errorcode);

            die("Couldn't create socket: [$errorcode] $errormsg \n");
        }

        echo "Socket created \n";

        $server_side_sock = Config::getConfig();;

        socket_sendto($socket, "Socket sent!", 12, 0, $server_side_sock['socket_path'], 0);
        echo "Socket sent\n";

    }
}