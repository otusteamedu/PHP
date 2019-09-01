<?php
while (true) {
    $socket = stream_socket_client(
        "unix://" . __DIR__ . "/socket.sock",
        $errno,
        $errstr,
        30
    );
    if (!$socket) {
        echo "$errstr ($errno)\n";
    }

    fwrite($socket, "Тук-тук-тук");
    echo fgets($socket, 1024);
    fclose($socket);
    sleep(rand(0, 10));
}
