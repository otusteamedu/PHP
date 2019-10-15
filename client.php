<?php

if (!extension_loaded('sockets')) {
    die('The sockets extension is not loaded.');
}

include 'classes/ClientClass.php';
$baseDir = __DIR__ . DIRECTORY_SEPARATOR;
$config = parse_ini_file($baseDir . 'config/config.ini');

$client_side_sock = $config['client'];
$server_side_sock = $config['server'];

$options = getopt("m:q", ["msg:","quit"]);

$msg = "";
$quit = false;

/**
 * Получить параметры через foreach,
 * чтобы при одновременном наличии короткого и длинного параметра выбрать крайний
 */
foreach ($options as $opt => $val) {
    if (is_array($val))
        die("В параметрах лишний \"$opt\" \n");
    
    switch ($opt) {
        case 'm':
        case 'msg':
            $msg = $val;
            break 1;
        case 'q':
        case 'quit':
            $quit = true;
            break 1;        
    }
}

$client = new ClientClass($client_side_sock);

$client->send($server_side_sock, $msg);
if ($quit) {
    $client->send($server_side_sock, 'X-Quit');
}
$client->stop();