<?php
namespace App;

class UnixServer
{

    public static function start($socket_file_name) {
        @unlink($socket_file_name.'.sock');

        $socket = stream_socket_server('unix://./'.$socket_file_name.'.sock', $errno, $errstr);
        if (!$socket) {
            echo "$errstr ($errno)<br />\n";
        } else {
            echo ("Ожидание сообщений..."). PHP_EOL;
            while ($conn = stream_socket_accept($socket)) {
                echo fread($conn, PHP_MAXPATHLEN). PHP_EOL;
                fclose($conn);
            }
            fclose($socket);
        }
    }
}