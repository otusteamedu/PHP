<?php
$pathSocket = __DIR__ . "/socket.sock";
if (file_exists($pathSocket)) {
    unlink($pathSocket);
}
$socket = stream_socket_server(
    "unix://" . $pathSocket,
    $errno,
    $errstr
);
if (!$socket) {
    echo "$errstr ( $errno )\n";
} else {
    while ($conn = stream_socket_accept($socket)) {
        $message = fread($conn, 1024);
        echo 'Кто-то стучится' . PHP_EOL;
        $data = 'Кто там?'. PHP_EOL;
        fwrite($conn, $data);
        fclose($conn);
    }
    fclose($socket);
}
