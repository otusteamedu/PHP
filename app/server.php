<?php

require_once(__DIR__ . '/vendor/autoload.php');
define('STOP' , 'stop');

use Marchenko\Config as Config;
use Marchenko\Server as Server;

$config = new Config("config.ini");
try {
  $server = new Server($config->get("server_socket"));
  while (true) {
    $value = $server->read();
    $msg = "Received: " . $value . PHP_EOL;
    echo $msg;
    file_put_contents('test.txt', $msg, FILE_APPEND);
    if (strtolower($value) == STOP) {
      break;
    }
  }
}
catch (Exception $e) {
  echo $e->getMessage() . "\n";
}



