<?php

if (!extension_loaded('sockets')) {
    die('The sockets extension is not loaded.');
}

include 'classes/ServerClass.php';
$baseDir = __DIR__ . DIRECTORY_SEPARATOR;
$config = parse_ini_file($baseDir . 'config/config.ini');
$server_log = $baseDir . $config['server_log'];
$error_log =  $baseDir . $config['error_log'];
if (!is_dir(dirname($server_log))) mkdir(dirname($server_log), 0777, true);
if (!is_dir(dirname($error_log)))  mkdir(dirname($error_log), 0777, true);

ini_set('error_log', $baseDir . $config['error_log']);
fclose(STDIN); fclose(STDOUT); fclose(STDERR);
$STDIN =  fopen('/dev/null', 'r');
$STDOUT = fopen($server_log, 'ab');
$STDERR = fopen($error_log,  'ab');

$server_side_sock = $config['server'];

$server = new ServerClass($server_side_sock);

$server->run();