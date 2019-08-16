<?php

while (true)
{
    $socket = stream_socket_client(
        "unix://" . __DIR__ . "/test.sock",
        $errno,
        $errstr,
        30
    );

    if (!$socket)
    {
        echo "$errstr ($errno)\n";
    }

    fwrite( $socket, "Сколько времени?" );
    echo fgets( $socket, 1024 );
    fclose($socket);
    sleep(10);
}


