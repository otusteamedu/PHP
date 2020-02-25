<?php
$ip = '127.0.0.1:8000';

if (PHP_SAPI === "cli") {
    $shortopts = "";
    $shortopts .= "s";
    $shortopts .= "c";

    $longopts = [
        "server",
        "client",
    ];

    $options = getopt($shortopts, $longopts);
    if (isset($options['client']) || isset($options['c'])) {
        echo "start client chat " . PHP_EOL;
        client_start($ip);
    }
    if (isset($options['server']) || isset($options['s'])) {
        echo "start server chat" . PHP_EOL;
        server_start($ip);
    }
}
;

function client_start($ip)
{
    $line = "";
    $stdin = fopen("php://stdin", "r");
    while ($line != 1) {
        $line = fgets($stdin);
        $response = shell_exec("curl $ip");
        echo $response . PHP_EOL;
    }
    fclose($stdin);
}

function server_start($ip)
{
    $socket = stream_socket_server("tcp://$ip", $errno, $errstr);
    if (!$socket) {
        die("$errstr ($errno)\n");
    }
    while ($connect = stream_socket_accept($socket, -1)) {
        echo $connect;
        fwrite($connect, "HTTP/1.1 200 OK\r\nContent-Type: text/html\r\nConnection: close\r\n\r\nПривет");
        fclose($connect);
        // fclose($socket);
    }
}
