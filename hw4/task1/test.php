<?php
$hosts = [
    'example.com',
    'localhost',
    'yandex.ru',
    'my-app',
    'no-host',
];

$queries = [
    '(()()()()))((((()()()))(()()()(((()))))))',
    '((()()()()))((((()()()))(()()()(((()))))))',
    ')(()()()()))((((()()()))(()()()(((()))))))(',
    ')(()()()()))((((()()()))(()()()(((())))))))'
];

foreach ($queries as $query) {
    $data = 'string='.$query;

    $request = "POST / HTTP/1.1\n";
    $request .= "Host: ".$hosts[rand(0, count($hosts)-1)]."\n";
    $request .= "Content-Type: application/x-www-form-urlencoded\n";
    $request .= "Content-Length:".strlen($data)."\n";
    $request .= "Connection: close\r\n";
    $request .= "\n";
    $request .= $data."\n";

    echo 'Request:'.PHP_EOL;
    echo $request.PHP_EOL;

    $socket = socket_create(AF_INET, SOCK_STREAM, 0);
    $conn = socket_connect($socket, 'app.local', 80);

    socket_write($socket, $request, strlen($request));

    echo 'Response:'.PHP_EOL;
    while ($response = socket_read($socket, 2)) {
        echo $response;
    }

    echo PHP_EOL;
    socket_close($socket);
}
