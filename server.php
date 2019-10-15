<?php

if (!extension_loaded('sockets')) {
    die('The sockets extension is not loaded.');
}

include 'classes/ServerClass.php';
$baseDir = __DIR__ . DIRECTORY_SEPARATOR;
$config = parse_ini_file($baseDir . 'config/config.ini');

ini_set('error_log', $baseDir . $config['error_log']);
fclose(STDIN); fclose(STDOUT); fclose(STDERR);
$STDIN = fopen('/dev/null', 'r');
$STDOUT = fopen($baseDir . $config['server_log'], 'ab');
$STDERR = fopen($baseDir . $config['error_log'], 'ab');

$server_side_sock = $config['server'];

$server = new ServerClass($server_side_sock);

$server->run();